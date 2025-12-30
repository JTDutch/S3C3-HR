# Use the official PHP image with Apache for version 8.1.32
FROM php:8.1.32-apache

# Install required system packages + PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    jq \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql mysqli \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application code
COPY . /var/www/html

# Force-remove .env (belt + suspenders)
RUN rm -f /var/www/html/.env

# Set Apache document root to /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

# Allow .htaccess
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Enable Apache rewrite
RUN a2enmod rewrite

# Correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP
EXPOSE 80

# Start Apache directly (NO entrypoint script)
CMD ["apache2-foreground"]
