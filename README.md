# trigves-arm-laravel
This is a Rapid Application Development tool designed to speed up the work flow by taking out the need to run back and forth from the database. It works on database tables and rows by mapping a multidementional array to the relational database the same way an Orm maps an object. Once installed you call a function that checks for new row names or missing row names in the tablesArray. If updates are needed it does them automatically relieving the need to go back and forth to the database every time you add a new row or table. This branch is for Laravel projects. I will be updating it with new features and creating other branchs for symfony, code-igniter and custom php projects.

Fixing errors so give me while to finish edits. Thanks.

INSTALLATION  
1) Place Development folder in the app directory.  
2) Place the ArmServiceProvider.php in the app/Providers directory.  
3) Place 'App\Providers\ArmServiceProvider::class,' in the providers array in config/app  
4) Add App::make('App\Development\Arm')->ArmCheckTables(); in the routes/web.php about all routes.  
5) Create the table in phpmyadmin and fill in your .env variables.


3/10/2017 - updates  
* added support for adding multiple rows in a table that are next to each other.  
* added support for droping unneeded tables - just erase them from the array.  
