FROM php:7.1

RUN apt-get update && apt-get install -y git zlib1g-dev zip && docker-php-ext-install zip
RUN pecl install xdebug-2.5.0 && docker-php-ext-enable xdebug
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html
