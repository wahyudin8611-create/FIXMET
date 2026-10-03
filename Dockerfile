# FIXMATE production image (used by Render). Apache + PHP 8.3 + SQLite.
FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev libjpeg62-turbo-dev libwebp-dev libfreetype6-dev libzip-dev unzip \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install gd zip \
    && a2enmod rewrite headers proxy proxy_http proxy_wstunnel \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Serve Laravel's public/ folder and allow its .htaccess rewrites
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Up to 5 photos of 5 MB each, and time for the AI photo analysis
RUN printf "upload_max_filesize=6M\npost_max_size=32M\nmax_file_uploads=10\nmax_execution_time=180\nmemory_limit=256M\nexpose_php=Off\n" > "$PHP_INI_DIR/conf.d/fixmate.ini"

# Proxy WebSocket (/app) ke server Reverb lokal untuk live chat real-time
COPY docker/reverb-proxy.conf /etc/apache2/conf-available/reverb-proxy.conf
RUN a2enconf reverb-proxy

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache database

# Live chat real-time (Reverb):
#   - REVERB_SERVER_*  : alamat Reverb mendengarkan di dalam container
#   - REVERB_*         : target publikasi sisi-server (Laravel -> Reverb) via localhost
#   - REVERB_CLIENT_*  : alamat untuk browser (di-proxy Apache -> Reverb);
#                        override di Render bila domain berubah
ENV APP_NAME=FIXMATE \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/html/database/database.sqlite \
    SESSION_DRIVER=database \
    CACHE_STORE=database \
    QUEUE_CONNECTION=sync \
    FILESYSTEM_DISK=local \
    AI_PROVIDER=gemini \
    BROADCAST_CONNECTION=reverb \
    REVERB_SERVER_HOST=0.0.0.0 \
    REVERB_SERVER_PORT=8080 \
    REVERB_HOST=127.0.0.1 \
    REVERB_PORT=8080 \
    REVERB_SCHEME=http \
    REVERB_CLIENT_HOST=fixmate.site \
    REVERB_CLIENT_PORT=443 \
    REVERB_CLIENT_SCHEME=https

RUN sed -i 's/$//' docker-start.sh

CMD ["sh", "/var/www/html/docker-start.sh"]
