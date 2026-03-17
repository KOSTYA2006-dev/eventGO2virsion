<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользовательское соглашение - EventGo</title>
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
            background: #050b10;
            color: #e6f7ee;
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
            background: rgba(5, 11, 16, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(12, 148, 136, 0.5);
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
            color: #64f0a3;
            text-shadow: 0 0 8px rgba(100, 240, 163, 0.8);
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
            font-size: 2.3rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            color: #e6f7ee;
            text-shadow: 0 0 10px rgba(15, 23, 42, 0.9);
        }

        .content-card {
            background: radial-gradient(circle at top, #0b1120, #020617);
            border: 1px solid rgba(12, 148, 136, 0.5);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 24px 55px rgba(15, 23, 42, 0.9);
            line-height: 1.8;
        }

        .content-card h2 {
            font-size: 1.5rem;
            margin: 2rem 0 1rem 0;
            color: #e6f7ee;
            text-shadow: none;
        }

        .content-card h2:first-child {
            margin-top: 0;
        }

        .content-card p {
            margin-bottom: 1rem;
            color: #cbd5f5;
        }

        .content-card ul {
            margin-left: 2rem;
            margin-bottom: 1rem;
        }

        .content-card li {
            margin-bottom: 0.5rem;
            color: #e6f7ee;
        }

        footer {
            background: rgba(5, 11, 16, 0.9);
            border-top: 1px solid rgba(12, 148, 136, 0.5);
            color: #e6f7ee;
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
            color: #64f0a3;
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            text-shadow: 0 0 10px rgba(100, 240, 163, 0.6);
        }

        .btn-back {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #0b1120, #020617);
            border: 1px solid rgba(100, 240, 163, 0.7);
            border-radius: 6px;
            color: #e6f7ee;
            text-decoration: none;
            margin-top: 2rem;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #111827, #020617);
            box-shadow: 0 22px 40px rgba(15, 23, 42, 0.9);
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

            .content-card h2 {
                font-size: 1.25rem;
            }

            .content-card p {
                font-size: 0.95rem;
            }

            .content-card ul {
                margin-left: 1.5rem;
            }

            .content-card li {
                font-size: 0.95rem;
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

            .content-card h2 {
                font-size: 1.1rem;
                margin: 1.5rem 0 0.75rem 0;
            }

            .content-card p {
                font-size: 0.9rem;
            }

            .content-card ul {
                margin-left: 1.25rem;
            }

            .content-card li {
                font-size: 0.9rem;
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
            <h1 class="page-title">ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ</h1>

            <div class="content-card">
                <p style="text-align: center; margin-bottom: 2rem; font-weight: bold;">
                    ПУБЛИЧНАЯ ОФЕРТА<br>
                    на оказание услуг по продаже билетов на мероприятия
                </p>

                <h2>1. ОБЩИЕ ПОЛОЖЕНИЯ</h2>
                <p>
                    Настоящая публичная оферта (далее – «Оферта») является официальным предложением 
                    {{ config('payment.recipient_name', 'ИП ЛАЗАРЕВА СВЕТЛАНА ИГОРЕВНА') }} 
                    (далее – «Исполнитель») заключить договор оказания услуг на условиях, изложенных ниже.
                </p>
                <p>
                    В соответствии с пунктом 2 статьи 437 Гражданского кодекса Российской Федерации 
                    данный документ является публичной офертой. Акцепт настоящей оферты означает 
                    полное и безоговорочное принятие Покупателем всех условий без каких-либо изъятий 
                    и ограничений.
                </p>

                <h2>2. ПРЕДМЕТ ДОГОВОРА</h2>
                <p>
                    Исполнитель обязуется оказать Покупателю услуги по продаже билетов на мероприятия, 
                    а Покупатель обязуется оплатить указанные услуги в порядке и на условиях, 
                    предусмотренных настоящей Офертой.
                </p>

                <h2>3. ПОРЯДОК ОКАЗАНИЯ УСЛУГ</h2>
                <ul>
                    <li>Покупатель выбирает билет на сайте и оформляет заказ</li>
                    <li>Покупатель заполняет форму с контактными данными</li>
                    <li>Покупатель производит оплату выбранного билета</li>
                    <li>После оплаты билет отправляется на указанный email адрес</li>
                    <li>Билет является электронным документом, подтверждающим право на посещение мероприятия</li>
                </ul>

                <h2>4. СТОИМОСТЬ УСЛУГ И ПОРЯДОК ОПЛАТЫ</h2>
                <p>
                    Стоимость услуг указана на сайте и может быть изменена Исполнителем в одностороннем порядке. 
                    Оплата производится путем перечисления денежных средств через платежную систему YooKassa 
                    или иными способами, указанными на сайте.
                </p>

                <h2>5. ПРАВА И ОБЯЗАННОСТИ СТОРОН</h2>
                <p><strong>Исполнитель обязуется:</strong></p>
                <ul>
                    <li>Оказать услуги в соответствии с условиями настоящей Оферты</li>
                    <li>Предоставить билет после получения оплаты</li>
                    <li>Обеспечить конфиденциальность персональных данных Покупателя</li>
                </ul>
                <p><strong>Покупатель обязуется:</strong></p>
                <ul>
                    <li>Предоставить достоверную информацию при оформлении заказа</li>
                    <li>Своевременно оплатить выбранные услуги</li>
                    <li>Сохранить билет до момента посещения мероприятия</li>
                </ul>

                <h2>6. ВОЗВРАТ СРЕДСТВ</h2>
                <p>
                    Возврат денежных средств за билеты осуществляется в соответствии с законодательством 
                    Российской Федерации. Возврат возможен не позднее чем за 3 дня до начала мероприятия.
                </p>

                <h2>7. ОТВЕТСТВЕННОСТЬ СТОРОН</h2>
                <p>
                    Исполнитель не несет ответственности за отмену или перенос мероприятия организатором. 
                    В случае отмены мероприятия возврат денежных средств осуществляется в полном объеме.
                </p>

                <h2>8. ЗАКЛЮЧИТЕЛЬНЫЕ ПОЛОЖЕНИЯ</h2>
                <p>
                    Настоящая Оферта вступает в силу с момента размещения на сайте и действует до момента 
                    отзыва Оферты Исполнителем.
                </p>
                <p>
                    Все споры решаются путем переговоров, а при недостижении соглашения – в соответствии 
                    с законодательством Российской Федерации.
                </p>
                <p style="margin-top: 2rem;">
                    <strong>Реквизиты Исполнителя:</strong><br>
                    {{ config('payment.recipient_name', 'ИП ЛАЗАРЕВА СВЕТЛАНА ИГОРЕВНА') }}<br>
                    ИНН: {{ config('payment.vtb_inn', '616404172802') }}<br>
                    ОГРНИП: {{ config('payment.ogrnip', '316616400101234') }}
                </p>
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

