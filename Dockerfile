FROM trafex/php-nginx:3.6.0

# Add composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy config
COPY ./misc/setup/docker/php.ini /etc/php83/conf.d/settings.ini

USER root
# Create cache folder
RUN mkdir /cache && chown -R nobody:nogroup /cache
# Install deps
RUN apk add --no-cache php83-redis php83-zip php83-tokenizer

USER nobody
# Copy source
COPY --chown=nobody . /var/www/html

# Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-cache

EXPOSE 8080
