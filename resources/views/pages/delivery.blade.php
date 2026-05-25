<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доставка и получение - EventGo</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/eventgo-static-pages.css') }}">
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <header>
            <nav>
                <a href="{{ route('index') }}" class="logo">EVENTGO</a>
                <a href="{{ route('index') }}" class="nav-home-link">ГЛАВНАЯ</a>
                <div class="header-socials" aria-label="Социальные сети">
                    <a class="social-link social-link--tg" href="https://t.me/podolog_rostov_sila" target="_blank" rel="noopener noreferrer" aria-label="Telegram">
                        <span class="social-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" class="social-svg">
                                <path d="M9.04 15.47 8.8 18.9c.36 0 .52-.16.71-.35l1.7-1.63 3.53 2.58c.65.36 1.1.17 1.27-.6l2.3-10.78c.2-.94-.34-1.31-.98-1.07L4.7 10.07c-.92.36-.9.88-.16 1.1l3.43 1.07 7.96-5.02c.38-.23.72-.1.44.13l-6.47 5.86Z"/>
                            </svg>
                        </span>
                        <span class="social-text">Telegram</span>
                    </a>
                    <a class="social-link social-link--vk" href="https://vk.ru/studia_sila" target="_blank" rel="noopener noreferrer" aria-label="ВКонтакте">
                        <span class="social-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" class="social-svg">
                                <path d="M12.96 16.83c-3.7 0-5.81-2.54-5.9-6.77h1.85c.06 3.11 1.43 4.43 2.51 4.7V10.06h1.74v2.68c1.06-.11 2.17-1.34 2.55-2.68h1.74c-.29 1.66-1.49 2.89-2.34 3.4.85.41 2.2 1.49 2.72 3.37h-1.92c-.41-1.29-1.44-2.29-2.75-2.43v2.43h-.2Z"/>
                            </svg>
                        </span>
                        <span class="social-text">ВК</span>
                    </a>
                </div>
            </nav>
        </header>

        <div class="container">
            <h1 class="page-title">ДОСТАВКА И ПОЛУЧЕНИЕ ЗАКАЗА</h1>

            <div class="content-card">
                <div class="highlight-box">
                    <p class="static-lead">
                        📧 Электронная доставка билетов
                    </p>
                    <p>
                        Все билеты доставляются в электронном виде на указанный при оформлении заказа email адрес 
                        сразу после успешной оплаты.
                    </p>
                </div>

                <h2>Способ получения билета</h2>
                <p>
                    После успешной оплаты заказа вы получите на указанный email адрес:
                </p>
                <ul>
                    <li><strong>Чек об оплате</strong> - подтверждение оплаты заказа</li>
                    <li><strong>Электронный билет</strong> - ваш билет на мероприятие в формате HTML</li>
                </ul>

                <h2>Сроки доставки</h2>
                <p>
                    Билеты отправляются автоматически в течение нескольких минут после успешной оплаты. 
                    Если вы не получили билет в течение 30 минут, проверьте папку "Спам" или свяжитесь 
                    с нашей службой поддержки.
                </p>

                <h2>Как использовать билет</h2>
                <ul>
                    <li>Сохраните полученный билет на ваше устройство (телефон, планшет)</li>
                    <li>Распечатайте билет или покажите его на экране устройства при входе на мероприятие</li>
                    <li>Билет содержит уникальный номер заказа, который будет проверен при входе</li>
                    <li>Убедитесь, что на билете указаны ваши данные (ФИО, email)</li>
                </ul>

                <h2>Важная информация</h2>
                <div class="highlight-box">
                    <ul class="static-list-unindented">
                        <li>Билет является именным и не подлежит передаче третьим лицам</li>
                        <li>При входе на мероприятие необходимо предъявить документ, удостоверяющий личность</li>
                        <li>Билет действителен только на указанную дату и время мероприятия</li>
                        <li>В случае потери билета свяжитесь с нами для восстановления</li>
                    </ul>
                </div>

                <h2>Контроль качества</h2>
                <p>
                    Если вы столкнулись с проблемами при получении билета или у вас есть вопросы, 
                    пожалуйста, свяжитесь с нашей службой поддержки:
                </p>
                <ul>
                    <li>Email: {{ config('app.contact_email', 'support@eventgo.ru') }}</li>
                    <li>Телефон: {{ config('app.contact_phone', '89094368010') }}</li>
                </ul>
            </div>

            <a href="{{ route('index') }}" class="btn-back">← Вернуться на главную</a>
        </div>

        <footer>
            <div class="footer-content">
                <div class="footer-links">
                    <a href="{{ route('pages.requisites') }}">Реквизиты</a>
                    <a href="{{ route('pages.agreement') }}">Пользовательское соглашение</a>
                    <a href="{{ route('pages.delivery') }}">Доставка и получение</a>
                    <a href="{{ route('pages.contacts') }}">Контакты</a>
                </div>
                <p>&copy; {{ date('Y') }} EventGo. Все права защищены.</p>
                <p class="static-footer-note">
                    ИНН: {{ config('payment.vtb_inn', '616404172802') }} | 
                    ОГРНИП: {{ config('payment.ogrnip', '316616400101234') }}
                </p>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}"></script>
    <script src="{{ asset('assets/js/matrix.js') }}"></script>
</body>
</html>

