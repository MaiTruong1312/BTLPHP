FROM php:8.2-apache

# 1. System libs
RUN apt-get update && apt-get install -y \
    zip unzip git curl \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. PHP extensions
RUN docker-php-ext-install \
    pdo pdo_mysql mbstring zip gd

# 3. Apache: ÉP CHỈ LOAD 1 MPM
RUN a2dismod mpm_event \
    && a2dismod mpm_worker \
    && a2enmod mpm_prefork rewrite

# 4. DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# 5. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 6. Vendor
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts

# 7. Source
COPY . .

# 8. Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 9. KHÔNG artisan cache khi build
CMD ["apache2-foreground"]
