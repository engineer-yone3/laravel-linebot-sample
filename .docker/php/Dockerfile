FROM php:8.1-apache

RUN apt-get update && apt-get install -y git zip unzip libzip-dev vim libpng-dev libpq-dev libfreetype6-dev libjpeg-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_mysql mysqli zip sockets

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-configure gd --with-jpeg && docker-php-ext-install -j$(nproc) gd

RUN apt-get update && apt-get install -y locales \
    && echo "ja_JP.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen ja_JP.UTF-8

ENV LANG=ja_JP.UTF-8 \
    LANGUAGE=ja_JP:ja \
    LC_ALL=ja_JP.UTF-8
ENV PHP_DEBUG=1

COPY sites-available/000-default.conf /etc/apache2/sites-available/.
RUN a2enmod rewrite

COPY php.ini /usr/local/etc/php/conf.d/99-xdebug.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer

COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

WORKDIR /var/www/html

CMD ["/usr/local/bin/startup.sh"]