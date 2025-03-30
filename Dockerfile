# Use PHP-Apache as the base image
FROM php:8.2-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files to Apache server directory
COPY . /var/www/html/

# Expose port 80 for web access
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
