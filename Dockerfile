FROM ubuntu:18.04

RUN apt update && apt install libpng-dev apache2

ENV UNPAY_INSTALLATION_PATH /var/www/html

WORKDIR $UNPAY_INSTALLATION_PATH

RUN rm -rf *

COPY . .

COPY docker/etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf