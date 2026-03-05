# ⚡ Быстрый деплой за 5 минут

## 🚂 Railway (Самый простой способ)

1. **Push код в GitHub**

2. **Зарегистрируйтесь на** [railway.app](https://railway.app) (можно через GitHub)

3. **Создайте новый проект**:
   - Нажмите "New Project"
   - Выберите "Deploy from GitHub repo"
   - Выберите ваш репозиторий

4. **Добавьте MySQL Database**:
   - Нажмите "+ New" → "Database" → "Add MySQL"
   - Railway автоматически создаст базу данных и переменные окружения

5. **Настройте переменные окружения** в вашем Web Service:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:ваш-ключ-сгенерируйте-через-php-artisan-key-generate
   DB_CONNECTION=mysql
   DB_HOST=${{RAILWAY_PRIVATE_DOMAIN}}
   DB_PORT=3306
   DB_DATABASE=${{MYSQL_DATABASE}}
   DB_USERNAME=root
   DB_PASSWORD=${{MYSQL_ROOT_PASSWORD}}
   
   # ВАЖНО: Настройте APP_URL с HTTPS (исправит проблему Mixed Content):
   APP_URL=https://ваш-домен.railway.app
   MAIL_MAILER=smtp
   MAIL_HOST=ваш-smtp-хост
   MAIL_PORT=587
   MAIL_USERNAME=ваш-email
   MAIL_PASSWORD=ваш-пароль
   MAIL_FROM_ADDRESS=noreply@eventgo.ru
   MAIL_FROM_NAME="EventGo"
   
   VTB_ACCOUNT=ваш-расчетный-счет
   VTB_BIK=044525187
   VTB_INN=ваш-инн
   VTB_KPP=ваш-кпп
   RECIPIENT_NAME="Название организации"
   
   EVENT_DATE=2025-12-31 18:00:00
   ```
   
   **Важно:** Railway автоматически создаст переменные `MYSQL_DATABASE`, `MYSQL_ROOT_PASSWORD` и `RAILWAY_PRIVATE_DOMAIN` при добавлении MySQL. Вы можете использовать их напрямую в формате `${{VARIABLE_NAME}}`.

6. **Railway автоматически задеплоит** приложение!

7. **После деплоя выполните миграции** (через Railway CLI или через команду в настройках):
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

8. **Готово!** Ваше приложение доступно по адресу, который Railway предоставит.

---

## 🐳 Docker Compose (Локально или на VPS)

### Быстрый старт:

```bash
# 1. Создайте .env файл
cp .env.example .env

# 2. Настройте .env (особенно базу данных)

# 3. Запустите
docker-compose up -d

# 4. Выполните миграции
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed

# 5. Откройте http://localhost:8000
```

### Остановка:
```bash
docker-compose down
```

### Просмотр логов:
```bash
docker-compose logs -f app
```

---

## 🌐 Render

1. **Зарегистрируйтесь на** [render.com](https://render.com)

2. **Создайте новый Web Service**:
   - "New +" → "Web Service"
   - Подключите GitHub репозиторий

3. **Настройки**:
   - **Environment**: Docker
   - **Dockerfile Path**: `Dockerfile`
   - **Auto-Deploy**: Yes

4. **Добавьте MySQL Database**:
   - "New +" → "MySQL"
   - Запомните данные подключения

5. **Настройте переменные окружения** в Web Service (как в Railway)

6. **Деплой начнется автоматически!**

---

## 📝 Важные замечания

### После деплоя обязательно:

1. **Измените пароль администратора**:
   - Войдите в админ-панель: `/admin/login`
   - Email: `admin@eventgo.ru`
   - Пароль: `admin123`
   - Измените пароль!

2. **Настройте реальный SMTP** для отправки писем

3. **Проверьте настройки платежей** (реквизиты ВТБ)

4. **Установите правильную дату мероприятия**

---

## 🔧 Решение проблем

### Приложение не запускается:
- Проверьте логи: `docker-compose logs app`
- Убедитесь, что все переменные окружения установлены
- Проверьте подключение к базе данных

### Ошибки миграций:
- Убедитесь, что база данных создана
- Проверьте права доступа к БД
- Попробуйте: `php artisan migrate:fresh --force`

### Проблемы с правами доступа:
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

---

**Удачи! 🚀**

