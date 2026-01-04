FROM php:8.1.32-apache

# Install system packages + PHP extensions
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libcurl4-openssl-dev \
    jq \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql mysqli curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application code
COPY . /var/www/html

# Force-remove .env
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

EXPOSE 80

CMD ["apache2-foreground"]
