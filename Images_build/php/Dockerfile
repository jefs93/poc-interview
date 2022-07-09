FROM php:7.4-apache

RUN apt-get update && apt-get install -y libpq-dev postgresql && docker-php-ext-install pdo pdo_pgsql \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql

RUN mv /usr/local/etc/php/php.ini-production  /usr/local/etc/php/php.ini

# RUN echo "extension=pdo_pgsql" >> /usr/local/etc/php/php.ini

# RUN echo "extension=pgsql" >> /usr/local/etc/php/php.ini

# RUN echo "extension=php_pgsql.dll" >> /usr/local/etc/php/php.ini