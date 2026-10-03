#!/bin/sh
# Starts FIXMATE in the container: prepares storage and the SQLite database,
# seeds the knowledge base on a fresh database, then runs Apache.
set -e
cd /var/www/html

# Render tells the app which port to listen on
PORT="${PORT:-10000}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# A key is generated on start when none is configured
if [ -z "$APP_KEY" ]; then
    APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    export APP_KEY
fi

mkdir -p storage/logs storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views

FRESH_DATABASE=0
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    FRESH_DATABASE=1
fi

php artisan migrate --force
if [ "$FRESH_DATABASE" = "1" ]; then
    php artisan db:seed --force
fi

php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R www-data:www-data storage bootstrap/cache database

exec apache2-foreground
