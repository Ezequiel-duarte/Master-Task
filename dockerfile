# version de php
FROM php:8.2-apache 

RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis

# para escribir Apache
RUN a2enmod rewrite 
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

EXPOSE 80




