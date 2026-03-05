# Многостадийная сборка для Laravel приложения
FROM php:8.2-fpm-alpine AS base

# Установка системных зависимостей
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    mysql-client \
    nginx \
    supervisor \
    netcat-openbsd

# Установка PHP расширений
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка Node.js для сборки фронтенда
RUN apk add --no-cache nodejs npm

# Рабочая директория
WORKDIR /var/www/html

# Копирование файлов composer
COPY composer.json composer.lock ./

# Установка PHP зависимостей (без dev зависимостей для production)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Копирование остальных файлов
COPY . .

# Завершение установки Composer
RUN composer dump-autoload --optimize --classmap-authoritative

# Копирование файлов package.json
COPY package.json package-lock.json* ./

# Установка Node зависимостей и сборка фронтенда
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi && npm run build

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/public/assets

# Копирование конфигурации Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Копирование конфигурации Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Копирование скрипта запуска
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]

