# mini-sales

**How to run:**
    * Clone this project
    * Go to the folder application using cd command on your cmd or terminal
    * Run composer install on your cmd or terminal
    * Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
    * Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
    * Run php artisan key:generate
    * Run php artisan migrate
    * Run php artisan db:seed AdminSeeder
    * Run php artisan serve
    * Go to http://localhost:8000/

**How to test:**
For admin login use email: [admin@gmail.com] and password: [password].
After login add user. Then login with user email password and try to checkin and checkout.
After these cross check admin features if all works fine or not.
