# Airport Parking System

## Installation
1. git clone the project
2. __chmod 777 -R__ your storage and bootstrap/cache folders
3. run composer update
4. create your mysql database
5. copy .env.example to __.env__
6. modify your .env file and type your database credentials
7. run php artisan key:generate
8. then run php artisan migrate
9. lastly, run php artisan db:seed

#### Notes
- In making a revisions or updates, create your own branch and use __development__ branch as your code based.
- Once your done with your updates, create a pull request to development branch.