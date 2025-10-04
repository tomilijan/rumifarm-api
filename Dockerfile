FROM php:8.2-apache

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# Copy your app files
COPY . /var/www/html/

# Set correct permissions
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
