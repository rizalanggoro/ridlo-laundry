FROM php:8.2.28-fpm-alpine3.22

# install deps yang dibutuhkan untuk linux 
RUN apk add oniguruma-dev libzip-dev curl nginx && docker-php-ext-install pdo pdo_mysql mbstring zip

WORKDIR /var/www

# copy semua file yang dibutuhkan oleh laravel 
COPY . ./

# install composer
COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# copy konfigurasi nginx
COPY nginx.conf /etc/nginx/nginx.conf

EXPOSE 80
CMD ["/bin/sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]