composer install
php artisan migrate --force
heroku-php-apache2 public/
