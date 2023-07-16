# Use the official PHP image as the base image
FROM php:8.1-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev 

# Install PHP extensions, including pdo_mysql
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath xml zip curl mysqli pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the rest of the project files into the container
COPY . /var/www/html

# Copy the .env file
# If you want to use the .env file from your local machine, you can use the following command instead:
COPY .env .env
# However, it's recommended to use environment variables instead of copying the .env file in production.
# You can set the environment variables in the docker-compose.yml file.

# Generate the application key
RUN php artisan key:generate

# Install project dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 8000 for PHP-FPM (not port 80, as it's for Nginx or Apache)
EXPOSE 8000

# Copy custom php.ini configuration to the container
#COPY php.ini /usr/local/etc/php/conf.d/

# Start the Laravel application
#CMD php artisan serve --host=0.0.0.0 --port=8000

# Start PHP-FPM server
#CMD ["php-fpm"]

# Start the Laravel application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

