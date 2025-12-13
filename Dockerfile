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

# 3. DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5. Vendor
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts

# 6. Source
COPY . .

# 7. Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 8. CHỐT HẠ: FIX LỖI AH00534 (Thực hiện cuối cùng để không bị ghi đè)
# Lệnh này sẽ tìm và xóa TẤT CẢ các file config MPM (kể cả prefork, event, worker)
# Sau đó mới bật lại duy nhất mpm_prefork.
RUN find /etc/apache2/mods-enabled -name "mpm_*.load" -delete \
    && find /etc/apache2/mods-enabled -name "mpm_*.conf" -delete \
    && a2enmod mpm_prefork rewrite

# 9. CMD
CMD ["apache2-foreground"]
