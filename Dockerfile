FROM php:7.3-fpm

LABEL maintainer="Nguyen Cao Thang <nguyencaothangtp@gmail.com>"

# Install plugins
RUN apt-get update \
    && apt-get install -y autoconf pkg-config libssl-dev libpng-dev

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets
RUN docker-php-ext-install pdo
RUN docker-php-ext-install gd

RUN apt-get update \
    && apt-get install -y libzip-dev zip \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip

# Install Postgres driver
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install Supervisord
RUN apt-get update \
    && apt-get install -y nginx supervisor cron

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install Xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install OPCACHE
RUN docker-php-ext-install opcache

COPY ./ /var/www/html

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf

COPY cron.sh /cron.sh

# Open port 80 443
EXPOSE 80 443

# Run Supervisord
CMD /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
