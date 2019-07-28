FROM php:7.2-apache
    
RUN requirements="libmcrypt-dev g++ libicu-dev libpq-dev" \
    && apt-get update && apt-get install -y $requirements && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install json \
    && requirementsToRemove="g++" \
    && apt-get purge --auto-remove -y $requirementsToRemove

RUN a2enmod rewrite && service apache2 restart

COPY . /var/www
COPY ./public /var/www/html

EXPOSE 80