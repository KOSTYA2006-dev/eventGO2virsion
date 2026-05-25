<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты - EventGo</title>
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
            <h1 class="page-title">КОНТАКТЫ</h1>

            <div class="content-card">
                <div class="contact-section">
                    <h2>Свяжитесь с нами</h2>
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <div class="contact-info">
                            <div class="contact-label">Email</div>
                            <div class="contact-value">
                                <a href="mailto:{{ config('app.contact_email', 'info@eventgo.ru') }}">
                                    {{ config('app.contact_email', 'info@eventgo.ru') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div class="contact-info">
                            <div class="contact-label">Телефон</div>
                            <div class="contact-value">
                                <a href="tel:{{ config('app.contact_phone', '89094368010') }}">
                                    {{ config('app.contact_phone', '89094368010') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">🌐</div>
                        <div class="contact-info">
                            <div class="contact-label">Сайт</div>
                            <div class="contact-value">
                                <a href="{{ config('app.url', 'https://eventgo.ru') }}" target="_blank">
                                    {{ config('app.url', 'https://eventgo.ru') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-section">
                    <h2>Реквизиты</h2>
                    <div class="contact-item">
                        <div class="contact-icon">🏢</div>
                        <div class="contact-info">
                            <div class="contact-label">Наименование</div>
                            <div class="contact-value">
                                {{ config('payment.recipient_name', 'ИП ЛАЗАРЕВА СВЕТЛАНА ИГОРЕВНА') }}
                            </div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">🔢</div>
                        <div class="contact-info">
                            <div class="contact-label">ИНН</div>
                            <div class="contact-value">
                                {{ config('payment.vtb_inn', '616404172802') }}
                            </div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📋</div>
                        <div class="contact-info">
                            <div class="contact-label">ОГРНИП</div>
                            <div class="contact-value">
                                {{ config('payment.ogrnip', '316616400101234') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-section">
                    <h2>Время работы</h2>
                    <div class="contact-item">
                        <div class="contact-icon">⏰</div>
                        <div class="contact-info">
                            <div class="contact-label">Поддержка клиентов</div>
                            <div class="contact-value">
                                Понедельник - Пятница: 10:00 - 20:00<br>
                                Суббота - Воскресенье: 12:00 - 18:00
                            </div>
                        </div>
                    </div>
                </div>
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

