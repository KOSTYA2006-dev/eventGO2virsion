<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>EventGo - Купить билеты</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
</head>

<body data-event-date="{{ $eventDate }}">
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <header>
            <nav class="container home-nav">
                <div class="logo">EVENTGO</div>
                <div class="header-socials" aria-label="Социальные сети">
                    <a class="social-link social-link--tg" href="https://t.me/podolog_rostov_sila" target="_blank" rel="noopener noreferrer" aria-label="Telegram">
                        <span class="social-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" class="social-svg">
                                <path d="M9.04 15.47 8.8 18.9c.36 0 .52-.16.71-.35l1.7-1.63 3.53 2.58c.65.36 1.1.17 1.27-.6l2.3-10.78c.2-.94-.34-1.31-.98-1.07L4.7 10.07c-.92.36-.9.88-.16 1.1l3.43 1.07 7.96-5.02c.38-.23.72-.1.44.13l-6.47 5.86Z"/>
                            </svg>
                        </span>
                    </a>
                    <a class="social-link social-link--vk" href="https://vk.ru/studia_sila" target="_blank" rel="noopener noreferrer" aria-label="ВКонтакте">
                        <span class="social-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" class="social-svg">
                                <path d="M12.96 16.83c-3.7 0-5.81-2.54-5.9-6.77h1.85c.06 3.11 1.43 4.43 2.51 4.7V10.06h1.74v2.68c1.06-.11 2.17-1.34 2.55-2.68h1.74c-.29 1.66-1.49 2.89-2.34 3.4.85.41 2.2 1.49 2.72 3.37h-1.92c-.41-1.29-1.44-2.29-2.75-2.43v2.43h-.2Z"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </nav>
        </header>

        <main>
            <div class="hero">
                <div class="container">
                    <div class="hero-card">
                        <div class="hero-grid">
                            <div class="hero-left">
                                <div class="event-badge">
                                    <span class="event-badge-dot"></span>
                                    ЖИВОЕ МЕРОПРИЯТИЕ ДЛЯ ПРОФИ
                                </div>
                                <h1>Конференция, которая меняет карьеру</h1>
                                <p>
                                    Один день, который вы запомните надолго: топ‑спикеры, реальные кейсы и
                                    мощное комьюнити специалистов. Забронируйте место, пока есть билеты.
                                </p>

                                <div class="hero-highlights">
                                    <div class="hero-highlight">
                                        <div class="hero-highlight-title">1 день, максимум пользы</div>
                                        <div>Интенсивная программа без воды — только практические инсайты.</div>
                                    </div>
                                    <div class="hero-highlight">
                                        <div class="hero-highlight-title">Живое общение</div>
                                        <div>Нетворкинг, ответы на вопросы и личные контакты со спикерами.</div>
                                    </div>
                                    <div class="hero-highlight">
                                        <div class="hero-highlight-title">Ограниченное количество мест</div>
                                        <div>Ламповая атмосфера и внимание к каждому участнику.</div>
                                    </div>
                                </div>

                                <div class="hero-ctas">
                                    <a href="#tickets" class="btn-primary-hero">КУПИТЬ БИЛЕТ СЕЙЧАС</a>
                                    <a href="#photos" class="btn-secondary-hero">Посмотреть атмосферу мероприятия</a>
                                </div>
                                <div class="hero-note">
                                    Оплата онлайн, билет и чек приходят на ваш email автоматически.
                                </div>
                            </div>

                            <div class="hero-right">
                                <div class="hero-countdown-card">
                                    <div class="hero-countdown-header">
                                        <span class="hero-countdown-title">До начала мероприятия осталось</span>
                                        <span class="hero-countdown-date">{{ \Carbon\Carbon::parse($eventDate)->format('d.m.Y H:i') }}</span>
                                    </div>
                                    <div class="countdown" id="countdown">
                                        <div class="countdown-item">
                                            <span class="countdown-number" id="days">00</span>
                                            <span class="countdown-label">Дней</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number" id="hours">00</span>
                                            <span class="countdown-label">Часов</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number" id="minutes">00</span>
                                            <span class="countdown-label">Минут</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number" id="seconds">00</span>
                                            <span class="countdown-label">Секунд</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="photos">
                <div class="photo-section">
                    <div class="photo-section-header">
                        <div>
                            <div class="photo-section-title">Атмосфера мероприятия</div>
                            <div class="photo-section-subtitle">
                                Небольшой взгляд внутрь: как выглядят наши залы, участники и живая работа со спикерами.
                            </div>
                        </div>
                    </div>

                    <div class="photo-carousel" data-carousel>
                        <div class="photo-slides" data-carousel-slides>
                            <div class="photo-slide">
                                <div class="photo-visual">
                                    <div class="photo-card photo-card-main photo-card-bg-a">
                                        <div class="photo-card-label">Зал мероприятия</div>
                                    </div>
                                    <div class="photo-card photo-card-bg-b">
                                        <div class="photo-card-label">Живые выступления</div>
                                    </div>
                                    <div class="photo-card photo-card-bg-c">
                                        <div class="photo-card-label">Работа с залом</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="photo-content-title">Полное погружение в тему</div>
                                    <div class="photo-content-text">
                                        Вы попадаете в атмосферу, где каждый участник пришёл за конкретным результатом: знания,
                                        новые контакты и уверенность в своих действиях после мероприятия.
                                    </div>
                                    <ul class="photo-content-list">
                                        <li>• Большой экран с наглядными примерами и схемами</li>
                                        <li>• Удобные места, где можно конспектировать и задавать вопросы</li>
                                        <li>• Живой диалог со спикерами, а не сухие лекции</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="photo-slide">
                                <div class="photo-visual">
                                    <div class="photo-card photo-card-main photo-card-bg-d">
                                        <div class="photo-card-label">Нетворкинг</div>
                                    </div>
                                    <div class="photo-card photo-card-bg-e">
                                        <div class="photo-card-label">Кулуарные обсуждения</div>
                                    </div>
                                    <div class="photo-card photo-card-bg-f">
                                        <div class="photo-card-label">Новые знакомства</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="photo-content-title">Люди, с которыми хочется работать</div>
                                    <div class="photo-content-text">
                                        Мероприятие собирает профессионалов, близких вам по опыту и ценностям. Здесь легко
                                        найти партнёров, наставников и коллег для обмена опытом.
                                    </div>
                                    <ul class="photo-content-list">
                                        <li>• Уютные зоны для общения во время перерывов</li>
                                        <li>• Возможность задать личные вопросы спикерам</li>
                                        <li>• Контакты, которые останутся с вами после события</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="photo-slide">
                                <div class="photo-visual">
                                    <div class="photo-card photo-card-main photo-card-bg-g">
                                        <div class="photo-card-label">Практика</div>
                                    </div>
                                    <div class="photo-card photo-card-bg-h">
                                        <div class="photo-card-label">Разборы кейсов</div>
                                    </div>
                                    <div class="photo-card photo-card-bg-i">
                                        <div class="photo-card-label">Ответы на вопросы</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="photo-content-title">Максимум практики за один день</div>
                                    <div class="photo-content-text">
                                        Вместо абстрактных историй — конкретные кейсы, цифры и пошаговые схемы, которые можно
                                        применять уже на следующий день после мероприятия.
                                    </div>
                                    <ul class="photo-content-list">
                                        <li>• Подробный разбор ситуаций из практики</li>
                                        <li>• Чёткие рекомендации «что делать именно вам»</li>
                                        <li>• Материалы, которые останутся с вами после события</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="photo-carousel-dots" data-carousel-dots></div>
                    </div>
                </div>
            </div>

            <div class="container" id="tickets">
                <div class="tickets-section">
                    <h2 class="section-title">ВЫБЕРИТЕ БИЛЕТ</h2>

                    @if($tickets->count() > 0)
                        <div class="tickets-grid">
                            @foreach($tickets as $ticket)
                                <div class="ticket-card">
                                    <span class="ticket-badge {{ $ticket->type }}">{{ $ticket->type === 'vip' ? 'VIP' : 'ОБЫЧНЫЙ' }}</span>
                                    <h3 class="ticket-name">{{ $ticket->name }}</h3>
                                    <p class="ticket-description">{{ $ticket->description ?? 'Отличный билет для участия в мероприятии' }}</p>
                                    <div class="ticket-price">{{ $ticket->formatted_price }}</div>
                                    <a href="{{ route('orders.show', $ticket->id) }}" class="btn">КУПИТЬ БИЛЕТ</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="tickets-empty">Билеты пока не доступны</p>
                    @endif
                </div>
            </div>

            <div class="container" id="location">
                <div class="location-section">
                    <h2 class="section-title">ГДЕ ПРОЙДЁТ МЕРОПРИЯТИЕ</h2>
                    <div class="location-grid">
                        <div class="location-card">
                            <div class="location-title">ДонЭкспоцентр</div>
                            <div class="location-address">Ростов-на-Дону, пр-т Михаила Нагибина, 30</div>
                            <div class="location-note">
                                Удобная парковка и транспортная доступность. После покупки билет и чек придут на email.
                            </div>
                            <a class="location-route" href="https://www.google.com/maps?q=%D0%94%D0%BE%D0%BD%D0%AD%D0%BA%D1%81%D0%BF%D0%BE%D1%86%D0%B5%D0%BD%D1%82%D1%80%2C+%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82+%D0%9C%D0%B8%D1%85%D0%B0%D0%B8%D0%BB%D0%B0+%D0%9D%D0%B0%D0%B3%D0%B8%D0%B1%D0%B8%D0%BD%D0%B0+30%2C+%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2-%D0%BD%D0%B0-%D0%94%D0%BE%D0%BD%D1%83" target="_blank" rel="noopener noreferrer">
                                Построить маршрут
                            </a>
                        </div>
                        <div class="location-map">
                            <iframe
                                title="Карта: ДонЭкспоцентр, Ростов-на-Дону"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps?q=%D0%94%D0%BE%D0%BD%D0%AD%D0%BA%D1%81%D0%BF%D0%BE%D1%86%D0%B5%D0%BD%D1%82%D1%80%2C+%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82+%D0%9C%D0%B8%D1%85%D0%B0%D0%B8%D0%BB%D0%B0+%D0%9D%D0%B0%D0%B3%D0%B8%D0%B1%D0%B8%D0%BD%D0%B0+30%2C+%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2-%D0%BD%D0%B0-%D0%94%D0%BE%D0%BD%D1%83&output=embed">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="container">
                <div class="footer-links-row">
                    <a href="{{ route('pages.requisites') }}" class="footer-link">Реквизиты</a>
                    <a href="{{ route('pages.agreement') }}" class="footer-link">Пользовательское соглашение</a>
                    <a href="{{ route('pages.delivery') }}" class="footer-link">Доставка и получение</a>
                    <a href="{{ route('pages.contacts') }}" class="footer-link">Контакты</a>
                </div>
                <p>&copy; {{ date('Y') }} EventGo. Все права защищены.</p>
                <p class="footer-legal-meta">
                    ИНН: {{ config('payment.vtb_inn', '616404172802') }} |
                    ОГРНИП: {{ config('payment.ogrnip', '316616400101234') }}
                </p>
            </div>
        </footer>
    </div>

    <div class="social-float" aria-label="Социальные сети">
        <a class="social-float-link social-link--tg" href="https://t.me/podolog_rostov_sila" target="_blank" rel="noopener noreferrer" aria-label="Telegram">
            <svg viewBox="0 0 24 24" class="social-float-svg" aria-hidden="true">
                <path d="M9.04 15.47 8.8 18.9c.36 0 .52-.16.71-.35l1.7-1.63 3.53 2.58c.65.36 1.1.17 1.27-.6l2.3-10.78c.2-.94-.34-1.31-.98-1.07L4.7 10.07c-.92.36-.9.88-.16 1.1l3.43 1.07 7.96-5.02c.38-.23.72-.1.44.13l-6.47 5.86Z"/>
            </svg>
        </a>
        <a class="social-float-link social-link--vk" href="https://vk.ru/studia_sila" target="_blank" rel="noopener noreferrer" aria-label="ВКонтакте">
            <svg viewBox="0 0 24 24" class="social-float-svg" aria-hidden="true">
                <path d="M12.96 16.83c-3.7 0-5.81-2.54-5.9-6.77h1.85c.06 3.11 1.43 4.43 2.51 4.7V10.06h1.74v2.68c1.06-.11 2.17-1.34 2.55-2.68h1.74c-.29 1.66-1.49 2.89-2.34 3.4.85.41 2.2 1.49 2.72 3.37h-1.92c-.41-1.29-1.44-2.29-2.75-2.43v2.43h-.2Z"/>
            </svg>
        </a>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ asset('assets/js/matrix.js') }}" defer></script>
    <script src="{{ asset('assets/js/home.js') }}" defer></script>
</body>
</html>
