# Use official PHP Apache image
FROM php:8.2-apache

# Install PHP extensions you need
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into Apache root
COPY . /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80 (Render will map it automatically)
EXPOSE 80
