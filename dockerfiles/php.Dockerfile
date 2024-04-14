FROM php:8.2-fpm

WORKDIR /var/www/laravel

#install mysql
#RUN docker-php-ext-install pdo pdo_mysql

# Install required system packages and dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PDO and PDO PostgreSQL extensions
RUN docker-php-ext-install pdo pdo_pgsql

#install xdebug
RUN pecl install xdebug
COPY 90-xdebug.ini "${PHP_INI_DIR}"/conf.d