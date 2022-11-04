#!/bin/sh

cd /var/www/html

if [ -e .env ]; then
  :
else
  cp .env.local .env
fi

php artisan config:clear
php artisan storage:link
composer install -o

cd /var/www
chmod -R 777 html

apache2-foreground

exit 0