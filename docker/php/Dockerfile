FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev  --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip


RUN pecl install redis \
	&& pecl install xdebug \
	&& docker-php-ext-enable redis xdebug

ADD ./php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www
