FROM php:8.1-apache

RUN apt-get update && apt-get install -y git zip unzip libzip-dev vim libpng-dev libpq-dev libfreetype6-dev libjpeg-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_mysql mysqli zip sockets

COPY ./sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
RUN pecl install xdebug && docker-php-ext-enable xdebug

# RUN docker-php-ext-configure gd \
#     --withfreetype=/usr/include/ \
#     --with-jpeg=/usr/include \
#     && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-configure gd --with-jpeg && docker-php-ext-install -j$(nproc) gd
RUN a2enmod rewrite

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

COPY ./startup.sh /usr/local/bin/startup.sh

WORKDIR /var/www/html

CMD ["startup.sh"]