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

# Kredensial Reverb (live chat). Dibuat saat start bila belum di-set di env.
# Untuk stabilitas lintas restart, set REVERB_APP_ID/KEY/SECRET di dashboard Render.
if [ -z "$REVERB_APP_ID" ]; then
    REVERB_APP_ID="$(od -An -N4 -tu4 /dev/urandom | tr -d ' ')"
    export REVERB_APP_ID
fi
if [ -z "$REVERB_APP_KEY" ]; then
    REVERB_APP_KEY="$(head -c 16 /dev/urandom | od -An -tx1 | tr -d ' \n')"
    export REVERB_APP_KEY
fi
if [ -z "$REVERB_APP_SECRET" ]; then
    REVERB_APP_SECRET="$(head -c 16 /dev/urandom | od -An -tx1 | tr -d ' \n')"
    export REVERB_APP_SECRET
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

# Server Reverb (WebSocket) di latar belakang — auto-restart bila berhenti.
# Hanya diakses internal via proxy Apache (/app → 127.0.0.1:8080).
(
    while true; do
        php artisan reverb:start \
            --host="${REVERB_SERVER_HOST:-0.0.0.0}" \
            --port="${REVERB_SERVER_PORT:-8080}" \
            --no-interaction || true
        echo "Reverb berhenti, mencoba ulang dalam 2 detik..." >&2
        sleep 2
    done
) &

exec apache2-foreground
