sudo chmod -R 777 storage bootstrap &&
composer install &&
php artisan key:generate &&
php artisan db:seed