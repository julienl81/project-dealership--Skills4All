# Installation #

## Symfony ##

To install the project, after cloning the repository, run the following command:
```composer install```

## Database ##

First, create a user for the project. then edit the .env file to set the database name, user and password.

Then run the following command to create the database:
```php bin/console doctrine:database:create```

Then run the following command to create tables:
```php bin/console doctrine:migrations:migrate```

## Load fixtures ##

To load the fixtures, run the following command:
```php bin/console doctrine:fixtures:load```

## Run the project ##

Use Symfony server or php built-in server to run the project:
```symfony server:start``` or ```php -S localhost:8080 -t public```	