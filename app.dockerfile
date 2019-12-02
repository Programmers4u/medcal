FROM php:7.1.0-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    zlib1g-dev libicu-dev g++ \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql