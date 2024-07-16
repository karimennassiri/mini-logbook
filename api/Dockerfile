# Getting the PHP 8.2 FPM official image
FROM php:8.2-fpm

# Installing the necessary packages to run a Laravel project
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip

# Installing Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# We copy the project content in the /var/www folder of the container 
# And we defin the path as a work directory
COPY . /var/www
WORKDIR /var/www

# Installing dependencies 
RUN composer install

# Running the necessary permission commands
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www 

# Define the default user
USER www-data 

# Running PHP-FPM
CMD php-fpm

# Finally, we expose the 8000 port
EXPOSE 8000