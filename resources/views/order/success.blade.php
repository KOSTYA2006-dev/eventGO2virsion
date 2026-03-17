<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($order->payment_status === 'paid')
            Оплата успешна - Заказ №{{ $order->order_number }}
        @elseif($order->payment_status === 'cancelled')
            Оплата отменена - Заказ №{{ $order->order_number }}
        @else
            Статус оплаты - Заказ №{{ $order->order_number }}
        @endif
    </title>
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
            padding: 2rem 0;
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
            to { transform: translateY(100vh); }
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 40px;
        }

        @media screen and (max-width: 1200px) {
            .container {
                padding: 0 30px;
            }
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 0 20px;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                padding: 0 15px;
            }
        }

        .success-card {
            background: radial-gradient(circle at top, #0b1120, #020617);
            border: 1px solid rgba(12, 148, 136, 0.5);
            border-radius: 12px;
            box-shadow: 0 24px 55px rgba(15, 23, 42, 0.9);
            padding: 3rem 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .success-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                text-shadow: 0 0 20px #00ff41, 0 0 40px #00ff41;
                transform: scale(1);
            }
            50% {
                text-shadow: 0 0 30px #00ff41, 0 0 60px #00ff41, 0 0 80px #00ff41;
                transform: scale(1.1);
            }
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #e6f7ee;
            text-shadow: 0 0 12px rgba(15, 23, 42, 0.9);
            letter-spacing: 2px;
        }

        .success-message {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #cbd5f5;
        }

        .order-details {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(12, 148, 136, 0.6);
            border-radius: 10px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(30, 64, 175, 0.45);
            color: #cbd5f5;
        }

        .detail-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.25rem;
            margin-top: 0.5rem;
            padding-top: 1rem;
            text-shadow: 0 0 10px rgba(15, 23, 42, 0.9);
        }

        .detail-row span:first-child {
            font-weight: 600;
            text-shadow: none;
        }

        .info-message {
            background: rgba(15, 23, 42, 0.98);
            border: 1px solid rgba(148, 163, 184, 0.7);
            border-radius: 5px;
            padding: 1rem;
            margin: 2rem 0;
            color: #e6f7ee;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #0b1120, #020617);
            border: 1px solid rgba(100, 240, 163, 0.7);
            border-radius: 6px;
            color: #e6f7ee;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Ubuntu', monospace;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            margin-top: 1rem;
        }

        .btn:hover {
            background: linear-gradient(135deg, #111827, #020617);
            box-shadow: 0 22px 40px rgba(15, 23, 42, 0.9);
            transform: scale(1.03);
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 1rem 0;
            }

            .success-card {
                padding: 2rem 1.5rem;
            }

            .success-title {
                font-size: 2rem;
            }

            .success-message {
                font-size: 1.1rem;
            }

            .success-icon {
                font-size: 4rem;
            }

            .order-details {
                padding: 1.5rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.5rem;
                padding: 0.75rem 0;
            }

            .info-message {
                padding: 0.875rem;
                font-size: 0.95rem;
            }

            .btn {
                padding: 0.875rem 1.5rem;
                font-size: 0.95rem;
            }
        }

        @media screen and (max-width: 480px) {
            body {
                padding: 0.75rem 0;
            }

            .success-card {
                padding: 1.5rem 1.25rem;
            }

            .success-title {
                font-size: 1.5rem;
            }

            .success-message {
                font-size: 1rem;
            }

            .success-icon {
                font-size: 3rem;
            }

            .order-details {
                padding: 1.25rem;
            }

            .detail-row {
                padding: 0.5rem 0;
                font-size: 0.9rem;
            }

            .info-message {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.75rem 1.25rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">✓</div>
                @if($order->payment_status === 'paid')
                    <h1 class="success-title">ОПЛАТА УСПЕШНА</h1>
                    <p class="success-message">Ваш заказ оплачен. Мы отправим чек и билет на email.</p>
                @elseif($order->payment_status === 'cancelled')
                    <h1 class="success-title">ОПЛАТА ОТМЕНЕНА</h1>
                    <p class="success-message">Платёж не был завершён. Вы можете оформить заказ заново.</p>
                @else
                    <h1 class="success-title">ОПЛАТА В ПРОЦЕССЕ</h1>
                    <p class="success-message">Мы проверяем оплату. Обычно это занимает до пары минут.</p>
                @endif

                <div class="order-details">
                    <div class="detail-row">
                        <span>Номер заказа:</span>
                        <span>{{ $order->order_number }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Билет:</span>
                        <span>{{ $order->ticket->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span>Количество:</span>
                        <span>{{ $order->quantity }} шт.</span>
                    </div>
                    @if($order->promoCode)
                    <div class="detail-row">
                        <span>Промокод:</span>
                        <span style="color: #00ff41; text-shadow: 0 0 5px #00ff41;">{{ $order->promoCode->code }}</span>
                    </div>
                    @endif
                    <div class="detail-row">
                        <span>Итого:</span>
                        <span>{{ $order->formatted_total_amount }}</span>
                    </div>
                </div>

                <div class="info-message">
                    <p>Email: <strong>{{ $order->customer->email }}</strong></p>
                    <p style="margin-top: 0.5rem; font-size: 0.875rem; opacity: 0.8;">Проверьте папку "Входящие" или "Спам"</p>
                    @if($order->payment_status === 'paid')
                        @if($order->receipt_sent && $order->ticket_sent)
                            <p style="margin-top: 0.5rem; color: #00ff41; font-weight: bold;">✓ Чек и билет отправлены</p>
                        @else
                            <p style="margin-top: 0.5rem;">Отправляем чек и билет…</p>
                        @endif
                    @elseif($order->payment_status === 'cancelled')
                        <p style="margin-top: 0.5rem;">Если вы хотите купить билет — оформите заказ заново.</p>
                    @else
                        <p style="margin-top: 0.5rem;">Если письма не будет в течение 5 минут — попробуйте обновить страницу.</p>
                    @endif
                </div>

                <a href="{{ route('index') }}" class="btn">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}"></script>
    <script src="{{ asset('assets/js/matrix.js') }}"></script>
</body>
</html>

