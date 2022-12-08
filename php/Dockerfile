FROM php:8.1.13-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY ./php/src /var/www/html