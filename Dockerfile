FROM php:8.3-apache

# 1. Install ekstensi PostgreSQL dengan helper resmi
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql \
    && a2enmod rewrite

# 2. Sesuaikan konfigurasi Apache agar mau mendengarkan PORT dinamis dari Railway
ENV PORT=80
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf

WORKDIR /var/www/html
COPY . /var/www/html/

EXPOSE 80