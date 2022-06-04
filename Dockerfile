FROM php:8-apache
WORKDIR /var/www/html
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt update -y && apt upgrade -y \
    && apt install -y --no-install-recommends libzip-dev \
    && pecl install redis zip \
    && docker-php-ext-enable redis zip \
    && a2enmod rewrite headers \
    && mkdir /cache \
    && chown -R www-data:www-data /cache \
    && rm -rf /var/www/html/*

# Copy project to /var/www/html
COPY . .

# Run composer and clean
RUN composer update --no-cache \
    && composer install --no-interaction --optimize-autoloader --no-dev --no-cache \
    && apt autoclean -y \
    && apt autoremove -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /usr/bin/composer

EXPOSE 80
CMD apachectl -D FOREGROUND
