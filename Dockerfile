FROM php:8.1-fpm-alpine
WORKDIR /var/www/html
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN adduser -D proxitok
RUN apk update && apk upgrade --available \
    && apk add git libzip-dev autoconf build-base \
    && pecl install redis zip \
    && docker-php-ext-enable redis zip \
    && mkdir /cache \
    && chown -R proxitok:proxitok /cache \
    && rm -rf /var/www/html/* \
    && git clone --depth=1 https://github.com/unstablemaple/ProxiTok.git . \
    && composer update \
    && composer install  --no-interaction --optimize-autoloader --no-dev \
    && chown -R proxitok:proxitok /var/www/html \
    && chmod -R 777 /var/www/html/ \
    && apk cache clean \
    && rm -rf /var/lib/apk/lists/* \
    && rm -rf /usr/bin/composer

EXPOSE 9000
