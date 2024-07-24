# 使用 PHP 官方映像作為基底
FROM php:8.3.9-fpm

# 安裝必要的工具
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# 安裝 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 設定工作目錄
WORKDIR /var/www

# 複製 Laravel 應用程式內容
COPY . /var/www

RUN ls -la /var/www/public/css

# 安裝 Laravel 相依套件
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 設置文件權限
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/public \
    && chmod -R 775 /var/www/public/css \
    && chmod -R 775 /var/www/public/css/style.css \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# 切換到 www-data 用戶
USER www-data

# 清除 Laravel 緩存
RUN php artisan view:clear \
    && php artisan route:clear \
    && php artisan config:clear \
    && php artisan cache:clear

# 指定容器內的 PHP-FPM 服務為執行入口點
CMD ["php-fpm"]

EXPOSE 9000