# trigves-arm-laravel
This is a Rapid Application Development tool designed to speed up the work flow by taking out the need to run back and forth from the database. It works on database tables and rows by mapping a multidementional array to the relational database the same way an Orm maps an object. Once installed you call a function that checks for new row names or missing row names in the tablesArray. If updates are needed it does them automatically relieving the need to go back and forth to the database every time you add a new row or table. This branch is for Laravel projects.

YOU REALLY HAVE TO WATCH WHEN YOU ARE CREATING YOUR TABLES AND FIELDS 
* WHEN FIRST PUT INTO USE IT WILL ERASE ANYTHING DONE BEFORE IT AND CREATE A SAMPLE USER DATABASE
* NAMING TWO ROWS THE SAME WILL HALT EXECUTION AND CREATE AN ERROR  
* NAMING TWO TABLES THE SAME WILL HALT EXECUTION AND CREATE AN ERROR   
* STICK TO LOWER CASE IN THE SECTIONS THAT HAVE LOWER CASE AND ONLY USE UPPER CASE WHEN TYPING THE ROW  

I take no responsibility for lost data! Use at your risk. Happy Coding!!  

INSTALLATION  
1) Place Development folder in the app directory.  
2) Place the ArmServiceProvider.php in the app/Providers directory.  
3) Place 'App\Providers\ArmServiceProvider::class,' in the providers array in config/app  
4) Add App::make('App\Development\Arm')->ArmCheckTables(); in the routes/web.php about all routes.  
5) Create the table in phpmyadmin and fill in your .env variables.  

-- or --  
1) Go to root of Laravel Installation and run composer require trigves/arm  
2) Publish and adjust the tablesArray in Arm.php  


3/10/2017 - updates  
* added support for adding multiple rows in a table that are next to each other.  
* added support for droping unneeded tables - just erase them from the array.  

3/13/2017 - updates  
* added support for changing row names  
* added error reporting
