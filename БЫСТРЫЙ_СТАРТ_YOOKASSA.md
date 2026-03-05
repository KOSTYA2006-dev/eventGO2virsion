# 🚀 Быстрый старт с YooKassa

## Минимальная настройка (5 минут)

### 1. Добавьте в `.env`:

```env
YOOKASSA_SHOP_ID=ваш_shop_id
YOOKASSA_SECRET_KEY=ваш_секретный_ключ
YOOKASSA_TEST_MODE=true
USE_YOOKASSA=true

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ваш_email@gmail.com
MAIL_PASSWORD=пароль_приложения_gmail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=ваш_email@gmail.com
MAIL_FROM_NAME="EventGo"
```

### 2. Настройте webhook в YooKassa:

1. Войдите: https://yookassa.ru/my
2. Настройки → Уведомления
3. Добавьте URL: `https://ваш-домен.ru/payment/webhook`
4. Выберите событие: `payment.succeeded`

### 3. Очистите кеш:

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Готово! 

Теперь при оплате через YooKassa:
- ✅ Автоматически обновляется статус заказа
- ✅ Автоматически отправляется чек на email
- ✅ Автоматически отправляется билет на email
- ✅ В админке отображается вся информация о покупке

## 📧 Тестирование

1. Создайте заказ на сайте
2. Оплатите тестовой картой: `5555555555554444`
3. Проверьте email покупателя - должны прийти чек и билет
4. Проверьте админку `/admin/orders` - заказ должен быть "Оплачен"

## 📖 Подробная инструкция

См. файл `НАСТРОЙКА_YOOKASSA.md` для детальной информации.

