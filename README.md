# Airport Parking System

## Installation
1. git clone the project
2. *chmod 777 -R* to folders storage and bootstrap/cache
3. run composer update
4. create your mysql database
5. copy .env.example to .env
6. modify your .env file and type your database credentials
7. run php artisan key:generate
8. then run php artisan migrate
9. lastly, run php artisan db:seed