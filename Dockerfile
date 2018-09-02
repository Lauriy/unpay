FROM ubuntu:18.04

RUN apt update && apt install libpng-dev apache2 php-bcmath

WORKDIR /var/www/html

RUN rm -rf *

COPY . .

COPY docker/etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN composer install

RUN php artisan admin:install && artisan migrate

RUN npm install

RUN npm run prod

RUN chgrp -R www-data storage bootstrap/cache database && chmod -R ug+rwx storage bootstrap/cache database