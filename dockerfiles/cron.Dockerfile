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

# Add your script to the container
COPY create_file.sh /create_file.sh

# Make the script executable
RUN chmod +x /create_file.sh

# Add crontab file
COPY crontab /etc/crontabs/root

# Run crontab
CMD ["crond", "-f"]