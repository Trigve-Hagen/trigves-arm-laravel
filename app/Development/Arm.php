<?php
namespace App\Development;

use App\Providers\ArmServiceProvider;
use Illuminate\Support\ServiceProvider;

class Arm {
	private $_db_host, $_db_name, $_db_user, $_db_pass;
	private $tableMap = array();
	
	public function __construct() {
		$this->_db_host = env('DB_HOST');
		$this->_db_name = env('DB_DATABASE');
		$this->_db_user = env('DB_USERNAME');
		$this->_db_pass = env('DB_PASSWORD');
	}
	
	/*
	*
	* The first three fields after tablename are optional. They are
	* id INT NOT NULL AUTO_INCREMENT - 'id'=>'userid_c3po007r2d2'
	* create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP - 'created_at'=>'createdat_c3po007r2d2'
	* and updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP - 'updated_at'=>'updatedat_c3po007r2d2'
	* You can name the sections separated by the underscore anything - blogid_45g234y5g5y or createad_rewquy3o45ouy
	*
	*/
	private $_tablesArray = array(
		'users' => array('tablename'=>'users_c3po007r2d2', 'id'=>'userid_c3po007r2d2', 'created_at'=>'createdat_c3po007r2d2', 'updated_at'=>'updatedat_c3po007r2d2', 'name'=>'name_c3po007r2d2_VARCHAR_255', 'cell'=>'cell_c3po007r2d2_VARCHAR_255', 'email'=>'email_c3po007r2d2_VARCHAR_255', 'username'=>'username_c3po007r2d2_VARCHAR_255', 'password'=>'password_c3po007r2d2_VARCHAR_255')
	);
	
	private function _Connect() {
		return mysqli_connect($this->_db_host, $this->_db_user, $this->_db_pass, $this->_db_name);
	}
	
	private function _ArmCreateNewTable($rowArray) { // do a created_at
		$queryString = "CREATE TABLE IF NOT EXISTS ".$rowArray['tablename']."(";
		if(isset($rowArray['id'])) $rowArray['id']." INT NOT NULL AUTO_INCREMENT, ";
		if(isset($rowArray['created_at'])) $queryString .= $rowArray['created_at']." TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ";
		if(isset($rowArray['updated_at'])) $queryString .= $rowArray['updated_at']." TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ";
		$rowcount = count($rowArray); $count = 1; 
		foreach($rowArray as $key => $value) {
			if($key == "id" || $key == "tablename" || $key == "created_at" || $key == "updated_at") {  } else {
				$args = explode("_", $value);
				if(isset($args[3])) $chars = "(" . $args[3] . ")"; else $chars = "";
				if($count == $rowcount) $queryString .= $value . " " . $args[2] . $chars;
				else $queryString .= $value . " " . $args[2] . $chars . ", ";
			}
			$count++;			
		}
		if(isset($rowArray['id'])) $queryString .= "PRIMARY KEY (".$rowArray['id']."))";
		else $queryString .= ")";
		//echo $queryString . "<br />";
		$mysqli = $this->_Connect();
		$query = mysqli_query($mysqli, $queryString);
	}
	
	// name . VARCHAR/TEXT/INT . 255
	private function _ArmAlterTable($tablename, $rowArray) { // add for inserting rows in between other rows
		$count = 0; $queryString = "ALTER TABLE ".$tablename." ADD (";
		foreach($rowArray as $row) {
			$args = explode("_", $row);
			if(isset($args[3])) $chars = "(" . $args[3] . ")"; else $chars = "";
			if($args[2] == "TEXT") $queryString .= $row." ".$args[2]." ".$chars;
			else {
				if($count == count($rowArray)-1) $queryString .= $row." ".$args[2]." ".$chars.")";
				else $queryString .= $row." ".$args[2]." ".$chars.", ";
			}
			$count++;
		}
		//echo $queryString;
		$mysqli = $this->_Connect();
		$query = mysqli_query($mysqli, $queryString); 
	}
	
	private function _TableExists($table) {
		$mysqli = $this->_Connect();
		$result = mysqli_query($mysqli, "select 1 from `" . $table . "` LIMIT 1");
		if($result) return true; else return false;
	}

	private function _GetListOfDatabases($key) {
		$mysqli = $this->_Connect(); $argsArray = array();
		$query = mysqli_query($mysqli, "DESCRIBE ".$this->_tablesArray[$key]['tablename']);
		while ($line = mysqli_fetch_array($query)) {
			array_push($argsArray, htmlentities($line['Field']));
		}
		return $argsArray;
	}
	
	// to set TEXT fields searchable in LIKE %search%
	private function _CreateCIMettaFields() {
		$mysqli = $this->_Connect();
		$query = mysqli_query($mysqli, "ALTER TABLE ".$this->_tablesArray['login']['tablename']." MODIFY COLUMN ".$this->_tablesArray['login']['metta']." TEXT CHARACTER SET UTF8 COLLATE UTF8_GENERAL_CI");
		$query = mysqli_query($mysqli, "ALTER TABLE ".$this->_tablesArray['blog']['tablename']." MODIFY COLUMN ".$this->_tablesArray['blog']['metta']." TEXT CHARACTER SET UTF8 COLLATE UTF8_GENERAL_CI");
		$query = mysqli_query($mysqli, "ALTER TABLE ".$this->_tablesArray['products']['tablename']." MODIFY COLUMN ".$this->_tablesArray['products']['metta']." TEXT CHARACTER SET UTF8 COLLATE UTF8_GENERAL_CI");
		mysqli_close($mysqli);
	}
	
	private function _CheckifEmpty($name) {
		$mysqli = $this->_Connect();
		$query = mysqli_query($mysqli, "SELECT * FROM ".$this->_tablesArray[$name]['tablename']);
		if($query == false || mysqli_num_rows($query) == 0) $ifempty = true;
		else $ifempty = false;
		mysqli_close($mysqli);
		return $ifempty;
	}
	
	public function ArmCheckTables() {
		foreach($this->_tablesArray as $key => $value) {
			if($this->_TableExists($this->_tablesArray[$key]['tablename'])) {
				$tablename = $this->_tablesArray[$key]['tablename'];
				$mysqli = $this->_Connect();
				$query = mysqli_query($mysqli, "SELECT * FROM ".$this->_tablesArray[$key]['tablename']);
				$numFields = mysqli_num_fields($query);
				if($numFields < count($this->_tablesArray[$key])-1) {
					// create a result list from the db and compare one by one till you find the new ones 
					$databaseArray = $this->_GetListOfDatabases($key); $argsArray = array();
					foreach($this->_tablesArray[$key] as $key => $value) {
						if($key == "tablename") { }
						else array_push($argsArray, $value);
					}
					//print_r($results); die();
					$results = array_diff($argsArray, $databaseArray);
					//foreach($results as $val) echo $val."<br />";
					$this->_ArmAlterTable($tablename, $results);
				}
			} else {
				$this->_ArmCreateNewTable($this->_tablesArray[$key]);
			}
		}
	}
	
	private function _BackUpToSql() { // escape commas as not to mess up sql statements
		if(file_exists('backup.sql')) unlink('backup.sql');
		foreach($this->_tablesArray as $key => $value) {
			if($this->_TableExists($this->_tablesArray[$key]['tablename'])) {
				$mysqli = $this->_Connect();
				$query = mysqli_query($mysqli, "SELECT * FROM ".$this->_tablesArray[$key]['tablename']);
				while ($line = mysqli_fetch_array($query)) {
					$dbrowcount = 1;
					$string = 'INSERT INTO '.$this->_tablesArray[$key]['tablename'].' VALUES(';
					foreach( $value as $key1 => $value1 ) {
						if($key1 != 'tablename') {
							$value = $line[$this->_tablesArray[$key][$key1]];
							if(preg_match("/,/", $value)) $escaped_value = str_replace(',', '%-2-C-;', $value);
							if($dbrowcount == count($value)-1) $string .= "'".$escaped_value."'";
							else $string .= "'".$escaped_value."', ";
							$dbrowcount++;
						}
					}
					$string .= ");" . PHP_EOL;
					$handle = fopen('backup.sql', 'ab');
					fwrite($handle,$string,strlen($string));
					fclose($handle);
				}
			}
		}
	}
	
	private function _InsertDataFromSql() {
		if(file_exists("backup.sql")) {
			$handle = fopen("backup.sql", "r");
			if($handle) {
				$mysqli = $this->_Connect();
				while(($line = fgets($handle)) !== false) $query = mysqli_query($mysqli, $line);
				mysqli_close($mysqli);
				fclose($handle);
			}
		}
	}
}

?>