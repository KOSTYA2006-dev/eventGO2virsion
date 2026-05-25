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
    <link rel="stylesheet" href="{{ asset('assets/css/order-success.css') }}">
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
                        <span class="detail-row-promo">{{ $order->promoCode->code }}</span>
                    </div>
                    @endif
                    <div class="detail-row">
                        <span>Итого:</span>
                        <span>{{ $order->formatted_total_amount }}</span>
                    </div>
                </div>

                <div class="info-message">
                    <p>Email: <strong>{{ $order->customer->email }}</strong></p>
                    <p class="info-message-hint">Проверьте папку "Входящие" или "Спам"</p>
                    @if($order->payment_status === 'paid')
                        @if($order->receipt_sent && $order->ticket_sent)
                            <p class="info-message-success">✓ Чек и билет отправлены</p>
                        @else
                            <p class="info-message-muted">Отправляем чек и билет…</p>
                        @endif
                    @elseif($order->payment_status === 'cancelled')
                        <p class="info-message-muted">Если вы хотите купить билет — оформите заказ заново.</p>
                    @else
                        <p class="info-message-muted">Если письма не будет в течение 5 минут — попробуйте обновить страницу.</p>
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

