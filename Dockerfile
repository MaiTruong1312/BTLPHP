# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# 1. Cài đặt các thư viện hệ thống
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

# 2. Bật mod_rewrite (cần cho Laravel)
RUN a2enmod rewrite

# 3. Set Apache Document Root → /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

# 4. Copy Composer từ container chính thức
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy file composer trước → tận dụng cache
COPY composer.json composer.lock ./

# 7. Cài vendor nhưng KHÔNG chạy scripts của Laravel
RUN composer install --no-dev --prefer-dist --no-progress --optimize-autoloader

# 8. Copy toàn bộ source code vào container
COPY . .

# 9. Cấp quyền cần thiết
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 10. KHÔNG chạy artisan cache tại build time (THẤY RẤT QUAN TRỌNG)
# Vì lúc này chưa có .env → chạy sẽ gây crash ở production.

# 11. Start Apache (QUAN TRỌNG – Railway cần dòng này)
CMD ["apache2-foreground"]
