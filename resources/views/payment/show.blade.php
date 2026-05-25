<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата заказа №{{ $order->order_number }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/payment-show.css') }}">
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <div class="container">
            <div class="payment-card">
                <div class="order-info">
                    <div class="order-number">ЗАКАЗ №{{ $order->order_number }}</div>
                    <div class="order-amount">{{ $order->formatted_total_amount }}</div>
                    <p>Оплата через платёжную систему <strong class="yookassa-brand">ЮKassa</strong></p>
                </div>

                @if($errors->any())
                    <div class="payment-alert-error">{{ $errors->first() }}</div>
                @endif

                <div class="yookassa-block">
                    <p class="yookassa-text">
                        Нажмите кнопку ниже — вы перейдёте на защищённую страницу ЮKassa, где можно оплатить картой, из кошелька ЮMoney и другими способами, доступными в ЮKassa.
                    </p>
                    <a href="{{ route('payment.start', $order->id) }}" class="btn btn-yookassa">Перейти к оплате в ЮKassa</a>
                </div>

                <div class="payment-details">
                    <div class="payment-details-row">
                        <span>Билет:</span>
                        <span>{{ $order->ticket->name }}</span>
                    </div>
                    <div class="payment-details-row">
                        <span>Количество:</span>
                        <span>{{ $order->quantity }} шт.</span>
                    </div>
                    @if($order->promoCode)
                    <div class="payment-details-row">
                        <span>Промокод:</span>
                        <span class="payment-details-promo">{{ $order->promoCode->code }}</span>
                    </div>
                    <div class="payment-details-row">
                        <span>Скидка:</span>
                        <span class="payment-details-promo">-{{ number_format($order->discount_amount, 2, '.', ' ') }} ₽</span>
                    </div>
                    @endif
                    <div class="payment-details-row">
                        <span>Итого:</span>
                        <span>{{ $order->formatted_total_amount }}</span>
                    </div>
                </div>

                <a href="{{ route('orders.checkout', $order->id) }}" class="btn btn-secondary-outline">← К промокоду и заказу</a>
                <a href="{{ route('index') }}" class="btn">На главную</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}"></script>
    <script src="{{ asset('assets/js/matrix.js') }}"></script>
</body>
</html>
