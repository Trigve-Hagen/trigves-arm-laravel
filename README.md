# trigves-arm-laravel
This is a Rapid Application Development tool designed to speed up the work flow by taking out the need to run back and forth from the database. It works on database tables and rows by mapping a multidementional array to the relational database the same way an Orm maps an object. Once installed you call a function that checks for new row names or missing row names in the tablesArray. If updates are needed it does them automatically relieving the need to go back and forth to the database every time you add a new row or table. This branch is for Laravel projects. I will be updating it with new features and creating other branchs for symfony, code-igniter and custom php projects.

Yea Buddy! All Done. There are two backup functions at the bottom. You might need to fix when there are commas in the database. In .sql statements it breaks them and the importing doesn't go well. The way it is you will have to create a search and replace function to run after importing and find %-2-C-; and replace them with ,   I wrote the code to replace , with %-2-C-; but the functions are untested as of now. Feel free to play with them. Will be creating the calls to automate php artisan make and migrate useage in the near future.

INSTALLATION  
1) Place Development folder in the app directory.  
2) Place the ArmServiceProvider.php in the app/Providers directory.  
3) Place 'App\Providers\ArmServiceProvider::class,' in the providers array in config/app  
4) Add App::make('App\Development\Arm')->ArmCheckTables(); in the routes/web.php about all routes.  
5) Create the table in phpmyadmin and fill in your .env variables.