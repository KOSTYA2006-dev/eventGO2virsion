# 🔒 Исправление проблемы Mixed Content (HTTP/HTTPS)

## Проблема: Mixed Content

Браузер блокирует загрузку ресурсов (CSS, JS, шрифты) по HTTP, когда страница загружена по HTTPS.

**Ошибка:**
```
Mixed Content: The page at 'https://...' was loaded over HTTPS, 
but requested an insecure stylesheet 'http://...'
```

## ✅ Решение

### Шаг 1: Установите APP_URL с HTTPS в Railway

1. Откройте ваш проект в Railway
2. Выберите ваш **Web Service**
3. Перейдите в **Settings** → **Variables**
4. Найдите переменную `APP_URL`
5. Установите значение:
   ```
   https://eventgo-production-8315.up.railway.app
   ```
   (замените на ваш реальный домен)

6. Если переменной нет - добавьте её:
   - Нажмите **"+ New Variable"**
   - Name: `APP_URL`
   - Value: `https://ваш-домен.railway.app`

### Шаг 2: Перезапустите сервис

1. В Railway найдите кнопку **"Restart"** или **"Redeploy"**
2. Нажмите на неё
3. Дождитесь перезапуска

### Шаг 3: Очистите кеш

В терминале Railway выполните:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
```

### Шаг 4: Очистите кеш браузера

1. Нажмите **Ctrl+Shift+Delete**
2. Выберите "Кешированные изображения и файлы"
3. Очистите кеш
4. Обновите страницу (**Ctrl+F5**)

## 🔍 Проверка

После исправления:

1. Откройте сайт
2. Нажмите **F12** (консоль разработчика)
3. Перейдите на вкладку **Console**
4. **Не должно быть** ошибок Mixed Content

5. Перейдите на вкладку **Network**
6. Все файлы должны загружаться по **HTTPS** (зеленый замочек)

## 📝 Что было исправлено в коде

1. **AppServiceProvider** - добавлена автоматическая настройка HTTPS:
   - Определяет HTTPS по переменной `APP_URL`
   - Определяет HTTPS через прокси-заголовки (Railway, Cloudflare)
   - Принудительно использует HTTPS в production

## 🚀 Быстрое исправление (одна команда)

В терминале Railway:

```bash
php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan config:cache
```

Затем перезапустите сервис в Railway.

## ⚠️ Важно

После установки `APP_URL` с HTTPS:
- Все ссылки `asset()` будут генерироваться с HTTPS
- Все внутренние ссылки будут использовать HTTPS
- Браузер не будет блокировать ресурсы

---

**Если проблема осталась:**
1. Убедитесь, что `APP_URL` установлен с `https://`
2. Проверьте, что сервис перезапущен
3. Очистите кеш браузера (Ctrl+F5)
4. Проверьте консоль браузера на наличие ошибок





