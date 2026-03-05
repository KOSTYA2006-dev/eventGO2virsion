# 🔧 Как исправить проблемы БЕЗ Railway CLI

## Способ 1: Через веб-интерфейс Railway (Самый простой)

### Шаг 1: Откройте ваш проект
1. Зайдите на [railway.app](https://railway.app)
2. Откройте ваш проект
3. Выберите ваш **Web Service** (не базу данных)

### Шаг 2: Найдите терминал/Shell
Есть несколько вариантов в зависимости от интерфейса Railway:

**Вариант A: Через Deployments**
1. Перейдите в раздел **"Deployments"**
2. Нажмите на последний деплой (самый верхний)
3. Найдите кнопку **"View Logs"** или **"Shell"**
4. Откроется терминал

**Вариант B: Через Settings**
1. Перейдите в **"Settings"** вашего Web Service
2. Найдите раздел **"Connect"** или **"Shell"**
3. Нажмите на кнопку для открытия терминала

**Вариант C: Прямо в интерфейсе**
1. В правом верхнем углу может быть кнопка **"Shell"** или **"Terminal"**
2. Нажмите на неё

### Шаг 3: Выполните команды
Когда откроется терминал, выполните команды **по одной**:

```bash
php artisan migrate --force
```

Нажмите Enter, дождитесь выполнения, затем:

```bash
php artisan db:seed --force
```

Затем:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
```

### Шаг 4: Перезапустите сервис
1. В Railway найдите кнопку **"Restart"** или **"Redeploy"**
2. Нажмите на неё
3. Дождитесь перезапуска

---

## Способ 2: Через один скрипт (Быстрее)

В терминале Railway выполните **одну команду**:

```bash
php artisan migrate --force && php artisan db:seed --force && php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan config:cache && php artisan route:cache
```

Это выполнит все команды подряд.

---

## Способ 3: Установите Railway CLI (Для будущего)

### Windows (PowerShell):
```powershell
iwr https://railway.app/install.ps1 -useb | iex
```

### Mac/Linux:
```bash
curl -fsSL https://railway.app/install.sh | sh
```

### Затем используйте:
```bash
railway login
railway link
railway run php artisan migrate --force
railway run php artisan db:seed --force
```

---

## Что делать после выполнения команд:

1. ✅ Обновите страницу сайта (Ctrl+F5 для полной перезагрузки)
2. ✅ Проверьте, что билеты появились
3. ✅ Проверьте, что фон работает
4. ✅ Проверьте, что верстка в порядке

---

## Если терминал не открывается:

1. Попробуйте другой браузер
2. Проверьте, что у вас есть доступ к проекту
3. Попробуйте перезагрузить страницу Railway
4. Используйте способ 3 (установите CLI)

---

## Важно:

После выполнения этих команд:
- Билеты создадутся автоматически (через seeder)
- Администратор создастся: `admin@eventgo.ru` / `admin123`
- Промокоды создадутся: `WELCOME10`, `VIP500`, `EARLY20`

**Не забудьте изменить пароль администратора после первого входа!**

