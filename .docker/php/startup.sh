#!/bin/sh

composer install --optimize-autoloader

cp -f .env.example .env

php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# マイグレーション & シーディング
php artisan migrate --force
php artisan db:seed --force

# storage:link の作成
if [ ! -L "/var/www/html/public/storage" ]; then
  php artisan storage:link
fi

# Apache 起動
exec apache2-foreground