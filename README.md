#Setup:

1. clone this repository
2. run `composer install && npm install`
3. edit .env.example file and save as .env with correct database details. ensure to use these values
   `
   APP_URL=http://localhost:8000
   VITE_API_BASE_URL="${APP_URL}/v1/"
   `
5. run `php artisan key:generate`
6. run `php artisan migrate:fresh --seed`

this will setup the app and seed the database

#Run it:
`php artisan serve`
`npm run dev`


