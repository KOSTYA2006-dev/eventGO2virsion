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
            <nav class="container">
                <div class="logo">EVENTGO</div>
                <div>
                    <a href="{{ route('admin.login') }}" class="admin-link">ADMIN</a>
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
                                    <div class="photo-card photo-card-main" style="background-image: linear-gradient(135deg, #02130a, #053d1e);">
                                        <div class="photo-card-label">Зал мероприятия</div>
                                    </div>
                                    <div class="photo-card" style="background-image: linear-gradient(135deg, #02130a, #0b5130);">
                                        <div class="photo-card-label">Живые выступления</div>
                                    </div>
                                    <div class="photo-card" style="background-image: linear-gradient(135deg, #02130a, #04502c);">
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
                                    <div class="photo-card photo-card-main" style="background-image: linear-gradient(135deg, #02130a, #064221);">
                                        <div class="photo-card-label">Нетворкинг</div>
                                    </div>
                                    <div class="photo-card" style="background-image: linear-gradient(135deg, #02130a, #074f29);">
                                        <div class="photo-card-label">Кулуарные обсуждения</div>
                                    </div>
                                    <div class="photo-card" style="background-image: linear-gradient(135deg, #02130a, #0b6b35);">
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
                                    <div class="photo-card photo-card-main" style="background-image: linear-gradient(135deg, #02130a, #055024);">
                                        <div class="photo-card-label">Практика</div>
                                    </div>
                                    <div class="photo-card" style="background-image: linear-gradient(135deg, #02130a, #0a5a31);">
                                        <div class="photo-card-label">Разборы кейсов</div>
                                    </div>
                                    <div class="photo-card" style="background-image: linear-gradient(135deg, #02130a, #0a7440);">
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
                        <p style="text-align: center; color: #00ff41; padding: 2rem; opacity: 0.7;">Билеты пока не доступны</p>
                    @endif
                </div>
            </div>
        </main>

        <footer>
            <div class="container">
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-bottom: 1rem;">
                    <a href="{{ route('pages.requisites') }}" style="color: #00ff41; text-decoration: none; transition: all 0.3s;">Реквизиты</a>
                    <a href="{{ route('pages.agreement') }}" style="color: #00ff41; text-decoration: none; transition: all 0.3s;">Пользовательское соглашение</a>
                    <a href="{{ route('pages.delivery') }}" style="color: #00ff41; text-decoration: none; transition: all 0.3s;">Доставка и получение</a>
                    <a href="{{ route('pages.contacts') }}" style="color: #00ff41; text-decoration: none; transition: all 0.3s;">Контакты</a>
                </div>
                <p>&copy; {{ date('Y') }} EventGo. Все права защищены.</p>
                <p style="margin-top: 0.5rem; font-size: 0.875rem; opacity: 0.8;">
                    ИНН: {{ config('payment.vtb_inn', '616404172802') }} |
                    ОГРНИП: {{ config('payment.ogrnip', '316616400101234') }}
                </p>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ asset('assets/js/matrix.js') }}" defer></script>
    <script src="{{ asset('assets/js/home.js') }}" defer></script>
</body>
</html>
