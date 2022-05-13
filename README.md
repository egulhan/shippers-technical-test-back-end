# Shippers Technical Test Project / Back-End

[Go to front-end repo of this project](https://github.com/egulhan/shippers-technical-test-front-end)

## Project setup

1. Download the source code to your machine.<br><br>

2. Run the following commands in order:

```
composer install
cp .env.example .env
php artisan key:generate
```

3. Create a database on your MySQL server and update database environment variables (like below) in .env file based on your database
   settings.<br><br>
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=shippers
DB_USERNAME=root
DB_PASSWORD=
```

5. Migrate the migration files by running the following command:

```
php artisan migrate
```

5. If you want to create dummy records on the database, run the following command:

```
php artisan db:seed
```

6. Start the server:

```
php artisan serve
```

You're done with the setup. Enjoy!

## How to run tests

Run the following command in the project root folder:

```
./vendor/bin/phpunit
```
