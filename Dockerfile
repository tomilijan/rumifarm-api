# Use official PHP with Apache
FROM php:8.2-apache

# Copy all files to the web root
COPY . /var/www/html/

# Give Apache permission to read and execute
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html

# Enable common PHP extensions (optional but good for most PHP apps)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80
EXPOSE 80
