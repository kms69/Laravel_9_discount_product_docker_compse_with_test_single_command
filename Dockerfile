FROM composer:2.4 as build
COPY . /app/
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

FROM php:8.1-apache-buster as dev

ENV APP_ENV=dev
ENV APP_DEBUG=true
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y zip
RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/
COPY --from=build /usr/bin/composer /usr/bin/composer
RUN composer install --prefer-dist --no-interaction ;

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.dev /var/www/html/.env

RUN php artisan config:cache && \
    php artisan route:cache && \
    chmod 777 -R /var/www/html/storage/ && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite
