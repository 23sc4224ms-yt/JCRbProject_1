FROM serversideup/php:8.3-fpm-nginx

USER root

RUN install-php-extensions pgsql pdo_pgsql pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:22 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22 /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install \
    && npm run build \
    && rm -rf node_modules

RUN chmod +x /var/www/html/docker/render/start.sh \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

ENV SSL_MODE=off
ENV AUTORUN_ENABLED=false
ENV PHP_OPCACHE_ENABLE=1

USER www-data

CMD ["/var/www/html/docker/render/start.sh"]
