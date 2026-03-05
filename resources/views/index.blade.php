<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>EventGo - Купить билеты</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main-page.css') }}">
    <style>
        @font-face {
            font-family: 'Ubuntu';
            src: url('{{ asset("assets/text-style/Ubuntu/Ubuntu-Regular.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Ubuntu';
            src: url('{{ asset("assets/text-style/Ubuntu/Ubuntu-Bold.ttf") }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #000;
            color: #00ff41;
            font-family: 'Ubuntu', monospace;
            overflow-x: hidden;
            position: relative;
        }

        canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            display: block;
        }

        #matrix-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .matrix-column {
            position: absolute;
            top: -100%;
            color: #00ff41;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.2;
            animation: matrix-fall linear infinite;
            text-shadow: 0 0 5px #00ff41;
        }

        @keyframes matrix-fall {
            to {
                transform: translateY(100vh);
            }
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
        }

        header {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid #00ff41;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.3);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            gap: 20px;
            max-width: 1720px;
            margin: 0 auto;
            padding-left: 40px;
            padding-right: 40px;
        }

        @media screen and (max-width: 1200px) {
            nav {
                padding-left: 30px;
                padding-right: 30px;
            }
        }

        @media screen and (max-width: 768px) {
            nav {
                padding: 1rem 0;
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        @media screen and (max-width: 480px) {
            nav {
                padding: 0.8rem 0;
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #00ff41;
            text-shadow: 0 0 10px #00ff41, 0 0 20px #00ff41;
            letter-spacing: 3px;
        }

        .admin-link {
            color: #00ff41;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 1px solid #00ff41;
            border-radius: 5px;
            transition: all 0.3s;
            text-shadow: 0 0 5px #00ff41;
        }

        .admin-link:hover {
            background: rgba(0, 255, 65, 0.1);
            box-shadow: 0 0 15px rgba(0, 255, 65, 0.5);
        }

        .hero {
            text-align: center;
            padding: 4rem 0;
            color: #00ff41;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px #00ff41, 0 0 20px #00ff41, 0 0 30px #00ff41;
            letter-spacing: 2px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px #00ff41, 0 0 20px #00ff41, 0 0 30px #00ff41;
            }
            to {
                text-shadow: 0 0 20px #00ff41, 0 0 30px #00ff41, 0 0 40px #00ff41, 0 0 50px #00ff41;
            }
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 0 0 5px #00ff41;
            opacity: 0.9;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 3rem 0;
            flex-wrap: wrap;
        }

        .countdown-item {
            background: rgba(0, 255, 65, 0.1);
            border: 2px solid #00ff41;
            border-radius: 10px;
            padding: 2rem;
            min-width: 120px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.3);
            backdrop-filter: blur(5px);
        }

        .countdown-number {
            font-size: 3rem;
            font-weight: bold;
            display: block;
            color: #00ff41;
            text-shadow: 0 0 10px #00ff41;
        }

        .countdown-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0.5rem;
            opacity: 0.8;
        }

        .tickets-section {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #00ff41;
            border-radius: 15px;
            padding: 3rem 2rem;
            margin: 3rem 0;
            box-shadow: 0 0 30px rgba(0, 255, 65, 0.3);
            backdrop-filter: blur(10px);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            color: #00ff41;
            text-shadow: 0 0 10px #00ff41;
            letter-spacing: 2px;
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .ticket-card {
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #00ff41;
            border-radius: 10px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 65, 0.1), transparent);
            transition: left 0.5s;
        }

        .ticket-card:hover::before {
            left: 100%;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 30px rgba(0, 255, 65, 0.5);
            border-color: #00ff41;
        }

        .ticket-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 0.875rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 1rem;
            border: 1px solid #00ff41;
            background: rgba(0, 255, 65, 0.1);
            color: #00ff41;
            text-shadow: 0 0 5px #00ff41;
        }

        .ticket-badge.vip {
            background: rgba(0, 255, 65, 0.2);
            box-shadow: 0 0 15px rgba(0, 255, 65, 0.5);
        }

        .ticket-name {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #00ff41;
            text-shadow: 0 0 5px #00ff41;
        }

        .ticket-description {
            color: #00ff41;
            margin-bottom: 1.5rem;
            opacity: 0.8;
            min-height: 60px;
        }

        .ticket-price {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00ff41;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 10px #00ff41;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid #00ff41;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            background: rgba(0, 255, 65, 0.1);
            color: #00ff41;
            text-shadow: 0 0 5px #00ff41;
            font-family: 'Ubuntu', monospace;
        }

        .btn:hover {
            background: rgba(0, 255, 65, 0.2);
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
            transform: scale(1.05);
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            border-top: 2px solid #00ff41;
            color: #00ff41;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
            text-shadow: 0 0 5px #00ff41;
        }

        .container {
            padding: 0 40px !important;
            max-width: 1720px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 1200px) {
            .container {
                padding: 0 30px !important;
            }
            nav {
                padding: 1.2rem 0;
                padding-left: 30px !important;
                padding-right: 30px !important;
            }
            
            .logo {
                font-size: 1.75rem;
            }
            
            .admin-link {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 1rem 0;
                padding-left: 20px !important;
                padding-right: 20px !important;
                flex-wrap: wrap;
            }
            
            .logo {
                font-size: 1.5rem;
                letter-spacing: 1px;
            }
            
            .admin-link {
                padding: 0.4rem 0.7rem;
                font-size: 0.85rem;
            }

            .hero {
                padding: 2rem 0;
            }

            .hero h1 {
                font-size: 2rem;
                letter-spacing: 1px;
            }

            .hero p {
                font-size: 1rem;
                padding: 0 1rem;
            }

            .countdown {
                gap: 0.75rem;
                margin: 2rem 0;
            }

            .countdown-item {
                min-width: 70px;
                padding: 1rem 0.75rem;
            }

            .countdown-number {
                font-size: 1.75rem;
            }

            .countdown-label {
                font-size: 0.85rem;
            }

            .tickets-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .tickets-section {
                padding: 2rem 1rem;
                margin: 2rem 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .ticket-card {
                padding: 1.5rem;
            }

            .ticket-name {
                font-size: 1.5rem;
            }

            .ticket-price {
                font-size: 2rem;
            }

            .container {
                padding: 0 20px !important;
            }
            
            footer {
                padding: 1.5rem 0;
            }
            
            footer .container {
                padding: 0 20px !important;
            }
        }

        @media (max-width: 480px) {
            nav {
                padding: 0.8rem 0;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
            
            .logo {
                font-size: 1.25rem;
            }
            
            .admin-link {
                padding: 0.35rem 0.6rem;
                font-size: 0.75rem;
            }

            .hero {
                padding: 1.5rem 0;
            }

            .hero h1 {
                font-size: 1.5rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .countdown {
                gap: 0.5rem;
                margin: 1.5rem 0;
            }

            .countdown-item {
                min-width: 60px;
                padding: 0.75rem 0.5rem;
            }

            .countdown-number {
                font-size: 1.5rem;
            }

            .countdown-label {
                font-size: 0.75rem;
            }

            .tickets-section {
                padding: 1.5rem 0.75rem;
                margin: 1.5rem 0;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .ticket-card {
                padding: 1.25rem;
            }

            .ticket-name {
                font-size: 1.25rem;
            }

            .ticket-price {
                font-size: 1.75rem;
            }

            .btn {
                padding: 0.875rem 1.5rem;
                font-size: 0.9rem;
            }

            .container {
                padding: 0 15px !important;
            }
            
            footer {
                padding: 1rem 0;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
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
                    <h1>ДОБРО ПОЖАЛОВАТЬ</h1>
                    <p>Присоединяйтесь к нам для незабываемого опыта</p>
                    
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

            <div class="container">
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

    <script>
        // Проверка загрузки скриптов
        window.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing background scripts...');
        });
    </script>
    <script src="{{ secure_asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ secure_asset('assets/js/matrix.js') }}" defer></script>
    <script>
        // Countdown Timer
        let eventDate;
        let countdownInterval;
        
        // Обработка ошибок парсинга даты
        try {
            const dateString = '{{ $eventDate }}';
            eventDate = new Date(dateString).getTime();
            
            if (isNaN(eventDate)) {
                throw new Error('Invalid date format');
            }
        } catch (error) {
            console.error('Ошибка парсинга даты мероприятия:', error);
            // Fallback на дату по умолчанию
            eventDate = new Date('2026-10-21 18:00:00').getTime();
        }
        
        // Функция форматирования чисел с разделителями тысяч
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }
        
        // Функция форматирования с ведущими нулями
        function formatWithPadding(num, maxLength = 2) {
            return String(num).padStart(maxLength, '0');
        }
        
        // Функция плавного обновления значения с анимацией
        function updateValueWithAnimation(elementId, newValue, isDays = false) {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            const oldValue = element.textContent.replace(/\s/g, '');
            const newValueStr = isDays ? formatNumber(newValue) : formatWithPadding(newValue);
            
            if (oldValue !== newValueStr.replace(/\s/g, '')) {
                // Добавляем класс для анимации
                element.style.transition = 'all 0.3s ease';
                element.style.transform = 'scale(1.1)';
                element.style.opacity = '0.7';
                
                setTimeout(() => {
                    element.textContent = newValueStr;
                    element.style.transform = 'scale(1)';
                    element.style.opacity = '1';
                }, 150);
            }
        }
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = eventDate - now;

            if (distance < 0) {
                // Улучшенное сообщение о начале мероприятия
                const countdownElement = document.getElementById('countdown');
                if (countdownElement) {
                    countdownElement.innerHTML = `
                        <div style="
                            text-align: center; 
                            padding: 3rem 2rem; 
                            font-size: 2rem; 
                            font-weight: bold; 
                            color: #00ff41; 
                            text-shadow: 0 0 20px #00ff41, 0 0 40px #00ff41, 0 0 60px #00ff41;
                            animation: pulse-glow 2s ease-in-out infinite;
                            border: 2px solid #00ff41;
                            border-radius: 15px;
                            background: rgba(0, 255, 65, 0.1);
                            backdrop-filter: blur(10px);
                            box-shadow: 0 0 30px rgba(0, 255, 65, 0.5);
                        ">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
                            <div>МЕРОПРИЯТИЕ НАЧАЛОСЬ!</div>
                            <div style="font-size: 1rem; margin-top: 1rem; opacity: 0.8;">Добро пожаловать!</div>
                        </div>
                    `;
                }
                
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Обновляем значения с анимацией
            updateValueWithAnimation('days', days, true);
            updateValueWithAnimation('hours', hours);
            updateValueWithAnimation('minutes', minutes);
            updateValueWithAnimation('seconds', seconds);
        }

        // Добавляем CSS для анимации пульсации
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse-glow {
                0%, 100% {
                    text-shadow: 0 0 20px #00ff41, 0 0 40px #00ff41, 0 0 60px #00ff41;
                    transform: scale(1);
                }
                50% {
                    text-shadow: 0 0 30px #00ff41, 0 0 60px #00ff41, 0 0 90px #00ff41;
                    transform: scale(1.05);
                }
            }
        `;
        document.head.appendChild(style);

        // Запускаем таймер
        countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>
</html>
