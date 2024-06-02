# Use PHP 8 with Alpine Linux as base image
FROM php:8-alpine

# Set the working directory
WORKDIR /var/www/laravel

# Install required packages
RUN apk --no-cache add bash postgresql-dev

# Install PDO PostgreSQL extension
RUN docker-php-ext-install pdo pdo_pgsql

# Install required packages
RUN apk --no-cache add bash

# Add crontab file
COPY crontab /etc/crontabs/root

# Run crontab
CMD ["crond", "-f"]