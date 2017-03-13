# trigves-arm-laravel
This is a Rapid Application Development tool designed to speed up the work flow by taking out the need to run back and forth from the database. It works on database tables and rows by mapping a multidementional array to the relational database the same way an Orm maps an object. Once installed you call a function that checks for new row names or missing row names in the tablesArray. If updates are needed it does them automatically relieving the need to go back and forth to the database every time you add a new row or table. This branch is for Laravel projects. I will be updating it with new features and creating other branchs for symfony, code-igniter and custom php projects.

YOU REALLY HAVE TO WATCH WHEN YOU ARE CREATING YOUR TABLES AND FIELDS  
* NAMING TWO ROWS THE SAME WILL HALT EXECUTION AND CREATE AN ERROR  
* NO TWO FIELDS IN A TABLE CAN HAVE THE SAME NAME  
* NAMING TWO TABLES THE SAME WILL HALT EXECUTION AND CREATE AN ERROR  
* NO TWO TABLES CAN HAVE THE SAME NAME  

Due to adding new features to the class last week I was running into new errors. When debbugging I realized the new error was not a new error at all but this. If you had named two databases the same they would both be erased when dropping a table. I added new logic for reporting the error. I also adding logic to report having two rows with the same name and errors and messages for everything else. PLease be carefull anyways. I take no responsibility for lost data! Use at your risk. If I have no new problems to report in the next month of developing with it than it is done. Happy Coding!!  

INSTALLATION  
1) Place Development folder in the app directory.  
2) Place the ArmServiceProvider.php in the app/Providers directory.  
3) Place 'App\Providers\ArmServiceProvider::class,' in the providers array in config/app  
4) Add App::make('App\Development\Arm')->ArmCheckTables(); in the routes/web.php about all routes.  
5) Create the table in phpmyadmin and fill in your .env variables.


3/10/2017 - updates  
* added support for adding multiple rows in a table that are next to each other.  
* added support for droping unneeded tables - just erase them from the array.  

3/13/2017 - updates  
* added support for changing row names  
* added error reporting
