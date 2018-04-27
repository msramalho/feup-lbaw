#!/bin/bash
set -e

env >> /var/www/.env
php-fpm7.1 -D

cd /var/www
php artisan migrate --force
# php /var/www/artisan config:clear
# php /var/www/artisan db:seed

# env DB_HOST=127.0.0.1 php artisan migrate
nginx -g "daemon off;"
