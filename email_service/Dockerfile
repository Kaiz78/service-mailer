FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets


# Copier le fichier de configuration Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY src/ /var/www/html


# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install  



# Configurer les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

RUN php artisan config:clear
RUN php artisan key:generate


# Expose port 80
EXPOSE 80


# Start Apache and the consumer script
CMD ["sh", "-c", "php artisan app:consumer & apache2-foreground"]
