FROM php:7.1.0-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    zlib1g-dev libicu-dev g++ \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# get the scripts from the build context and make sure they are executable
COPY /docker-scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# install extensions
RUN /tmp/scripts/ext-gd.sh
 
#Install git
RUN apt-get update \
    && apt-get install -y git