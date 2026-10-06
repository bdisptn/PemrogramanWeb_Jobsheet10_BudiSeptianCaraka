FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor gettext-envsubst libpq \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del .build-deps

ENV PORT=80

WORKDIR /var/www/html
COPY . /var/www/html/
COPY nginx/default.conf.template /etc/nginx/templates/default.conf.template
COPY nginx/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/bin/sh", "-c", "envsubst '$PORT' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf && exec /usr/bin/supervisord -c /etc/supervisord.conf"]
