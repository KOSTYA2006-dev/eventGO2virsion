#!/bin/bash
# Скрипт для исправления проблем после деплоя
# Выполните этот скрипт внутри контейнера Railway

echo "🔧 Исправление проблем деплоя..."

echo "1️⃣ Очистка кеша..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "2️⃣ Выполнение миграций..."
php artisan migrate --force

echo "3️⃣ Создание начальных данных (билеты, админ, промокоды)..."
php artisan db:seed --force

echo "4️⃣ Оптимизация для production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "5️⃣ Проверка прав доступа..."
chmod -R 755 storage bootstrap/cache public/assets 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache public/assets 2>/dev/null || true

echo "✅ Готово! Проверьте сайт - билеты, фон и верстка должны работать."

