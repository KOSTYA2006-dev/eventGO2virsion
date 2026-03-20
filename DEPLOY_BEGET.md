# Развёртывание EventGo на хостинге Beget

## Подготовка

### 1. SSH и PHP

- Включите доступ по SSH в панели Beget: **Настройки → Техническая информация**.
- Подключитесь по SSH (PuTTY, Terminal и т.п.).

Установите нужную версию PHP (для Laravel 12 — PHP 8.2+):

```bash
export PATH=/usr/local/php/cgi/8.2/bin/:$PATH
php -v
```

### 2. База данных MySQL

- В панели Beget: **MySQL → Добавить базу данных**.
- Запомните: **хост**, **имя базы**, **логин**, **пароль** (на Beget логин обычно совпадает с именем базы).
- Хост часто `localhost` или `имя_пользователя.mysql.tools`.

---

## Установка проекта

### 3. Создание сайта и клонирование

В панели Beget создайте сайт (например, `eventgo`) и привяжите домен.

Подключитесь по SSH и выполните:

```bash
cd ~/
git clone https://github.com/KOSTYA2006-dev/eventGO2virsion.git eventgo
cd eventgo
```

### 4. Ссылка на public

Beget отдаёт сайт из `public_html`. У Laravel точкой входа служит папка `public`. Сделайте ссылку:

```bash
cd ~/eventgo
rm -rf public_html
ln -s public public_html
```

### 5. Установка зависимостей Composer

В проекте уже есть `composer.phar`. Установите зависимости (для production без dev-пакетов):

```bash
cd ~/eventgo
php composer.phar install --no-dev --optimize-autoloader
```

Если нужны dev-зависимости:

```bash
php composer.phar install --optimize-autoloader
```

При ошибке памяти:

```bash
COMPOSER_MEMORY_LIMIT=-1 php composer.phar install --no-dev --optimize-autoloader
```

---

## Настройка .env

### 6. Создание .env

```bash
cp .env.example .env
nano .env
```

### 7. Параметры для Beget

```env
APP_NAME=EventGo
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ваш-домен.ru

# Ключ сгенерируем ниже
APP_KEY=

# База данных Beget
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=имя_вашей_базы
DB_USERNAME=логин_базы
DB_PASSWORD=пароль_базы

# ЮKassa (оплата)
YOOKASSA_SHOP_ID=ваш_shop_id
YOOKASSA_SECRET_KEY=ваш_секретный_ключ
YOOKASSA_TEST_MODE=false

USE_YOOKASSA=true

# Почта Beget (если нужна отправка)
MAIL_MAILER=smtp
MAIL_HOST=smtp.beget.com
MAIL_PORT=465
MAIL_USERNAME=ваш_email@домен.ru
MAIL_PASSWORD=пароль_от_почты
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=ваш_email@домен.ru
MAIL_FROM_NAME="${APP_NAME}"
```

### 8. Генерация ключа и миграции

```bash
php artisan key:generate
php artisan config:cache
php artisan migrate --force
php artisan storage:link
```

### 9. Права доступа

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## Сборка фронтенда (если есть Vite/npm)

Если в проекте есть `package.json` и Vite:

**Локально** выполните:

```bash
npm install
npm run build
```

Затем скопируйте папку `public/build` на хостинг в `~/eventgo/public/build`.

На Beget npm может быть недоступен, поэтому сборку обычно делают локально или на CI.

---

## SSL и финальная проверка

### 10. SSL-сертификат

В панели Beget: **Сайты → SSL-сертификаты** → установите бесплатный Let's Encrypt.

### 11. Webhook ЮKassa

Для приёма уведомлений об оплате настройте в личном кабинете ЮKassa URL:

```
https://ваш-домен.ru/payment/webhook
```

Точный путь проверьте в `routes/web.php` и `PaymentController`.

---

## Краткий чеклист

- [ ] SSH включён, создан сайт и домен
- [ ] Клонирован репозиторий
- [ ] `ln -s public public_html`
- [ ] `php composer.phar install --no-dev --optimize-autoloader`
- [ ] Создан и настроен `.env` (БД, ЮKassa, APP_URL)
- [ ] `php artisan key:generate`
- [ ] `php artisan migrate --force`
- [ ] Права на `storage` и `bootstrap/cache`
- [ ] SSL включён
- [ ] Webhook ЮKassa настроен

---

## Обновление проекта

```bash
cd ~/eventgo
git pull
php composer.phar install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan view:cache
```
