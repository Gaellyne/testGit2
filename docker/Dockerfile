FROM php:7.2.0-apache

ARG APP_ENV
ENV APP_ENV=$APP_ENV
ENV SYMFONY_ENV=$APP_ENV

# Install PHP PDO
RUN docker-php-ext-install pdo pdo_mysql


# Git

RUN apt-get update && apt-get install -y git

# Apache Conf

COPY docker/default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/ports.conf /etc/apache2/

RUN a2enmod rewrite headers proxy proxy_http

# Php Conf (Be careful to not erase previously php conf like memcached)
COPY docker/php.ini /usr/local/etc/php/php-ini
RUN cat /usr/local/etc/php/php-ini >> /usr/local/etc/php/php.ini \
    && rm /usr/local/etc/php/php-ini
#Copy apache2 conf
COPY docker/apache2.conf /etc/apache2/apache2.conf

# Copy source for Dockerized app

COPY / /var/www/html

WORKDIR /var/www/html
chmod -R 777 var/*
#RUN chmod +x /usr/local/bin/docker-entrypoint.sh
#ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
