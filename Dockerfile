FROM php:8.0-apache
WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt update -y && apt install -y libzip-dev \
    && pecl install redis zip \
    && docker-php-ext-enable redis zip \
    && a2enmod rewrite headers

RUN ["mkdir", "/cache"]
RUN ["chown", "-R", "www-data:www-data", "/cache"]

COPY . .
RUN composer update \
    && composer install --no-interaction --optimize-autoloader --no-dev
