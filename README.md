## Laravel_Auth_API

Laravel API Blog with laravel 10 and  mysql.

## Installation

1.Clone the project

    git clone https://github.com/Moyhe/Laravel_Blog_API.git

2.Navigate to the project root directory using command line and run

    composer install

3.Copy .env.example into .env

    cp .env.example .env

4.Adjust Database parameters, If you want to use Mysql, make sure you have mysql server up and running. 

5.Set encryption key

    php artisan key:generate --ansi

6.Run migrations

    php artisan migrate

7.to run the server you can use this command

    php artisan serve


8.use postman to test the API