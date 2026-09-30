FROM php:8.3-apache

# Install ekstensi PostgreSQL & matikan MPM yang berkonflik
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . /var/www/html/

EXPOSE 80