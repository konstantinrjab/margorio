FROM php:8.1-fpm

# git zip unzip are used by composer
RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev libjpeg-dev libpng-dev git libzip-dev zip unzip wkhtmltopdf

RUN docker-php-ext-configure gd --enable-gd --with-jpeg \
    && docker-php-ext-install pdo_pgsql pdo_mysql pcntl gd \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . .

CMD ["php-fpm"]
