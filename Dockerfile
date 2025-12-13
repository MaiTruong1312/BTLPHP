# ================================
# PHP 8.2 + Apache (Laravel)
# ================================
FROM php:8.2-apache

# 1. Cài thư viện hệ thống
RUN apt-get update && apt-get install -y \
    zip unzip git curl \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Cài PHP extensions
RUN docker-php-ext-install \
    pdo pdo_mysql mbstring zip gd

# 3. Apache: CHỈ DÙNG 1 MPM (QUAN TRỌNG)
RUN a2dismod mpm_event mpm_worker \
    && a2enmod mpm_prefork rewrite

# 4. Set DocumentRoot -> /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# 5. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Workdir
WORKDIR /var/www/html

# 7. Copy composer trước (cache Docker)
COPY composer.json composer.lock ./

# 8. Cài vendor (KHÔNG chạy script)
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts

# 9. Copy source code
COPY . .

# 10. Quyền thư mục Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 11. Apache chạy foreground
CMD ["apache2-foreground"]
