FROM php:8.2-apache

# 1. System libs
# QUAN TRỌNG: Thêm --no-install-recommends để tránh cài rác gây xung đột MPM
RUN apt-get update && apt-get install -y --no-install-recommends \
    zip unzip git curl \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. PHP extensions
RUN docker-php-ext-install \
    pdo pdo_mysql mbstring zip gd

# 3. Apache Configuration (Xử lý xung đột MPM An toàn)
# - Thử tắt mpm_event và mpm_worker. Thêm '|| true' để nếu không có thì bỏ qua, không lỗi.
# - Sau đó ép bật mpm_prefork (bắt buộc cho PHP).
RUN a2dismod mpm_event || true \
    && a2dismod mpm_worker || true \
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

# 9. Test Config (Kiểm tra lỗi ngay khi build)
RUN apache2ctl configtest

CMD ["apache2-foreground"]
