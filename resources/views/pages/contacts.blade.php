<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты - EventGo</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <style>
        @font-face {
            font-family: 'Ubuntu';
            src: url('{{ asset("assets/text-style/Ubuntu/Ubuntu-Regular.ttf") }}') format('truetype');
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
            min-height: 100vh;
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

        .content-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid #00ff41;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 40px;
            padding-right: 40px;
            gap: 20px;
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
            text-shadow: 0 0 10px #00ff41;
            letter-spacing: 3px;
            text-decoration: none;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 40px;
            flex: 1;
        }

        @media screen and (max-width: 1200px) {
            .container {
                padding: 2rem 30px;
            }
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 1.5rem 20px;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 1rem 15px;
            }
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            color: #00ff41;
            text-shadow: 0 0 10px #00ff41;
        }

        .content-card {
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid #00ff41;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 30px rgba(0, 255, 65, 0.3);
        }

        .contact-section {
            margin-bottom: 2rem;
        }

        .contact-section h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #00ff41;
            text-shadow: 0 0 5px #00ff41;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 255, 65, 0.3);
        }

        .contact-item:last-child {
            border-bottom: none;
        }

        .contact-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            width: 40px;
            text-align: center;
        }

        .contact-info {
            flex: 1;
        }

        .contact-label {
            font-weight: bold;
            color: #00ff41;
            margin-bottom: 0.25rem;
        }

        .contact-value {
            color: rgba(0, 255, 65, 0.9);
        }

        .contact-value a {
            color: rgba(0, 255, 65, 0.9);
            text-decoration: none;
            transition: all 0.3s;
        }

        .contact-value a:hover {
            text-shadow: 0 0 10px #00ff41;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            border-top: 2px solid #00ff41;
            color: #00ff41;
            padding: 2rem 0;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #00ff41;
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            text-shadow: 0 0 10px #00ff41;
        }

        .btn-back {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: rgba(0, 255, 65, 0.1);
            border: 2px solid #00ff41;
            border-radius: 5px;
            color: #00ff41;
            text-decoration: none;
            margin-top: 2rem;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: rgba(0, 255, 65, 0.2);
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.5);
        }

        @media screen and (max-width: 1200px) {
            .logo {
                font-size: 1.75rem;
            }
        }

        @media screen and (max-width: 768px) {
            .logo {
                font-size: 1.5rem;
                letter-spacing: 2px;
            }

            .page-title {
                font-size: 2rem;
            }

            .content-card {
                padding: 1.5rem;
            }

            .contact-section h2 {
                font-size: 1.25rem;
            }

            .contact-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem 0;
            }

            .contact-icon {
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .contact-label {
                font-size: 0.9rem;
            }

            .contact-value {
                font-size: 0.9rem;
            }

            .footer-content {
                padding: 0 20px;
            }

            .footer-links {
                gap: 1rem;
            }

            .btn-back {
                padding: 0.625rem 1.25rem;
                font-size: 0.9rem;
            }
        }

        @media screen and (max-width: 480px) {
            .logo {
                font-size: 1.25rem;
                letter-spacing: 1px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .content-card {
                padding: 1.25rem;
            }

            .contact-section {
                margin-bottom: 1.5rem;
            }

            .contact-section h2 {
                font-size: 1.1rem;
            }

            .contact-item {
                padding: 0.75rem 0;
            }

            .contact-icon {
                font-size: 1.25rem;
            }

            .contact-label {
                font-size: 0.85rem;
            }

            .contact-value {
                font-size: 0.85rem;
            }

            footer {
                padding: 1.5rem 0;
            }

            .footer-content {
                padding: 0 15px;
            }

            .footer-links {
                gap: 0.75rem;
                font-size: 0.85rem;
            }

            .btn-back {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <header>
            <nav>
                <a href="{{ route('index') }}" class="logo">EVENTGO</a>
                <a href="{{ route('index') }}" style="color: #00ff41; text-decoration: none;">ГЛАВНАЯ</a>
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
                                <a href="tel:{{ config('app.contact_phone', '+79991234567') }}">
                                    {{ config('app.contact_phone', '+7 (999) 123-45-67') }}
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
                <p style="margin-top: 0.5rem; font-size: 0.875rem; opacity: 0.8;">
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

