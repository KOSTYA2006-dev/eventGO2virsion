#!/bin/sh

# Ожидание готовности базы данных (если используется внешняя БД)
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "localhost" ] && [ "$DB_HOST" != "127.0.0.1" ]; then
  echo "Waiting for database at $DB_HOST..."
  while ! nc -z "$DB_HOST" "${DB_PORT:-3306}"; do
    sleep 1
  done
  echo "Database is ready!"
fi

# Очистка кеша
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Запуск миграций (если нужно)
if [ "$RUN_MIGRATIONS" = "true" ]; then
  echo "Running migrations..."
  php artisan migrate --force
  
  # Запуск seeders для создания начальных данных (билеты, админ и т.д.)
  if [ "$RUN_SEEDERS" = "true" ]; then
    echo "Running seeders..."
    php artisan db:seed --force
  fi
fi

# Оптимизация для production
if [ "$APP_ENV" = "production" ]; then
  echo "Optimizing for production..."
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
fi

# Запуск Supervisor (который запустит PHP-FPM и Nginx)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

