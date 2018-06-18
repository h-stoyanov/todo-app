## ToDo App
To start the app you have to make the following steps:
- Install Laravel dependencies with the command: `composer install`
- Install node modules with the command: `npm install`
- Run `npm run prod` to compile the required resources
- Setup your own database settings in .env file (you might need to create an empty database).
- Run `php artisan migrate:fresh --seed` to make the database and populate with users.

To login as admin use email `admin@admin.com` and password `toornimda`.
To login as user use email `user@user.com` and password `password`.