#!/bin/bash
set -e

env >> /var/www/.env
php-fpm7.1 -D
cd /var/www
php artisan migrate
nginx -g "daemon off;"
