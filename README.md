Setup:

1. clone this repository
2. run `composer install && npm install`
3. edit .env.example file and save as .env with correct database details
4. run `php artisan key:generate`
5. run `php artisan migrate:fresh --seed`

this will setup the app and seed the database
Run it:
`php artisan serve`

