FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable apache mod_rewrite if needed
RUN a2enmod rewrite

# Copy the application files to the Apache document root
COPY . /var/www/html/

# Expose port 80 for Render to route traffic
EXPOSE 80
