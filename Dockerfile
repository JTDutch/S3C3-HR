# Use the official PHP image with Apache for version 8.1.32
FROM php:8.1.32-apache

# Install necessary PHP extensions and netcat (netcat-openbsd)
RUN apt-get update && apt-get install -y libicu-dev netcat-openbsd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql mysqli


# Copy the application code to the container
COPY . /var/www/html

# Set the Apache document root to the public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Add Directory configuration to allow .htaccess overrides
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set permissions for the web server
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
