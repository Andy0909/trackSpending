# 指定基礎映像
FROM php:8.2-fpm

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# 安裝PHP擴展
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 安裝Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 設置工作目錄
WORKDIR /var/www

# 複製應用程序文件到容器
COPY . /var/www

# 安裝應用程序依賴
RUN composer install --optimize-autoloader --no-dev

# 複製.env文件並生成應用程序金鑰
RUN cp .env.example .env && php artisan key:generate

# 設置文件權限
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# 定義容器執行的命令
CMD php artisan serve --host=0.0.0.0 --port=80

# 暴露容器的端口
EXPOSE 80
