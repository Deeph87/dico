FROM php:7.2.3-fpm

ENV TIMEZONE=Europe/Paris


RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    libicu-dev \
    vim \
    locate

# Get composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone

# PHP Ext
RUN docker-php-ext-install pdo pdo_mysql intl

# Enable errors
RUN echo "error_log = /var/www/html/logs/php_error_log.log" >> /usr/local/etc/php/conf.d/php.ini
#RUN echo "error_reporting = e_all" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "log_errors = 1" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "display_errors = 1" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "extension = php_pdo_mysql.dll" >> /usr/local/etc/php/conf.d/php.ini

# install xdebug
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug
#RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#
#RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

WORKDIR /var/www/html