# Use the official PHP image as the base image
FROM php:8.2.8-apache

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libcurl4 \
    libcurl4-openssl-dev \
    libssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libzip-dev \
    curl \
    libssl-dev \
    zlib1g-dev \
    && docker-php-ext-install bcmath ctype fileinfo json mbstring openssl pdo pdo_mysql pdo_sqlite sockets tokenizer xml curl mysqli

# Install PHP extensions
RUN docker-php-ext-install bcmath ctype fileinfo json mbstring openssl pdo pdo_mysql pdo_sqlite sockets tokenizer xml curl mysqli


# Enable Apache Rewrite module
RUN a2enmod rewrite

# Copy the project files into the container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --optimize-autoloader --no-dev

# Set up environment variables
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Configure Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose port 80
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]
