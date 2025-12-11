FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files trước
COPY composer.json composer.lock ./

# Install vendor KHÔNG chạy script Laravel
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-progress \
    --no-scripts \
    --ignore-platform-reqs \
    --optimize-autoloader

# Copy toàn bộ source code
COPY . .

# Quyền lỗi nếu không đặt
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

CMD ["apache2-foreground"]
