FROM php:8.3-apache

# 1. Ambil helper resmi untuk install ekstensi PHP (tanpa mengganggu Apache)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# 2. Install ekstensi pdo_pgsql & aktifkan mod_rewrite
RUN install-php-extensions pdo_pgsql \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html/

EXPOSE 80