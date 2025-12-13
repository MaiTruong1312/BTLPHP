# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# 1. Cài đặt các thư viện hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev

# 2. Cài đặt PHP extensions (MySQL, GD, Zip...)
RUN docker-php-ext-install pdo pdo_mysql mbstring zip gd

# 3. Bật mod_rewrite cho Apache (để chạy .htaccess)
RUN a2enmod rewrite

# 3.1. Tắt các MPM có khả năng gây xung đột
RUN a2dismod mpm_event mpm_worker

# 4. Thiết lập thư mục gốc cho Apache trỏ vào /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 7. Copy file composer trước để tận dụng Docker cache
COPY composer.json composer.lock ./

# 8. Cài đặt các thư viện Laravel (vendor)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 9. Copy toàn bộ source code vào
COPY . .

# 10. QUAN TRỌNG NHẤT: Cấp quyền ghi CHO USER www-data (Phải làm bước này cuối cùng)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 11. Chạy lệnh tối ưu sau khi build
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache
