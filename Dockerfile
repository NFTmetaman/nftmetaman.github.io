# Use the official PHP image as the base image
FROM php:8.1-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath xml

# Set the working directory
WORKDIR /var/www/html

# Copy only necessary files into the container
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --optimize-autoloader --no-dev

# Copy the rest of the project files into the container
COPY . .

# Copy the .env file
COPY .env.example .env

# Generate the application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
