# Use the official PHP image with Apache as a base image
FROM php:8.2-apache

# Install PHP extensions required for MySQL connectivity
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the PHP site files to the Apache document root
COPY ./*.php /var/www/html/
COPY ./index.html /var/www/html/index.html

# Optional: Configure Apache to use the PHP site
#COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80 for the Apache web server
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
