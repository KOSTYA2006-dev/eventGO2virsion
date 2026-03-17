<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Промокод и оплата - Заказ №{{ $order->order_number }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/order-checkout.css') }}">
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <div class="container">
            <div class="card" data-subtotal="{{ (float) $order->ticket_price * (int) $order->quantity }}">
                <div class="card-header">
                    <h1>ПРОМОКОД И ОПЛАТА</h1>
                </div>
                <div class="card-content">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            {{ $errors->first('promo_code') ?? $errors->first() }}
                        </div>
                    @endif

                    <div class="summary">
                        <div class="summary-row">
                            <span>Номер заказа:</span>
                            <span><strong>{{ $order->order_number }}</strong></span>
                        </div>
                        <div class="summary-row">
                            <span>Билет:</span>
                            <span><strong>{{ $order->ticket->name }}</strong></span>
                        </div>
                        <div class="summary-row">
                            <span>Количество:</span>
                            <span>{{ $order->quantity }} шт.</span>
                        </div>
                        <div class="summary-row">
                            <span>Подитог:</span>
                            <span id="subtotal">{{ number_format($order->ticket_price * $order->quantity, 2, '.', ' ') }} ₽</span>
                        </div>
                        <div class="summary-row">
                            <span>Скидка:</span>
                            <span id="discount">{{ number_format($order->discount_amount ?? 0, 2, '.', ' ') }} ₽</span>
                        </div>
                        <div class="summary-row">
                            <span>Итого к оплате:</span>
                            <span id="total">{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</span>
                        </div>
                    </div>

                    <div class="promo-section">
                        <label class="label" for="promo_code">Промокод (необязательно)</label>

                        <form action="{{ route('orders.apply_promo', $order->id) }}" method="POST" id="promo-form">
                            @csrf
                            <div class="input-row">
                                <input type="text" id="promo_code" name="promo_code" value="{{ old('promo_code', $order->promoCode?->code) }}" placeholder="Введите промокод">
                                <button type="button" class="btn btn-secondary" id="check-promo-btn">Проверить</button>
                                <button type="submit" class="btn" id="apply-promo-btn">Применить</button>
                            </div>
                            <div id="promo-result" class="promo-result"></div>
                        </form>
                    </div>

                    <div class="actions">
                        <a href="{{ route('payment.show', $order->id) }}" class="btn">ОПЛАТИТЬ В ЮKASSA</a>
                        <a href="{{ route('orders.show', $order->ticket_id) }}" class="btn btn-secondary">ИЗМЕНИТЬ ДАННЫЕ</a>
                    </div>

                    <a href="{{ route('index') }}" class="back-link">← Вернуться на главную</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}"></script>
    <script src="{{ asset('assets/js/matrix.js') }}"></script>
    <script src="{{ asset('assets/js/order-checkout.js') }}"></script>
</body>
</html>
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        checkPromoBtn.addEventListener('click', async function() {
            const code = promoCodeInput.value.trim();
            if (!code) {
                promoResult.className = 'promo-result error';
                promoResult.textContent = 'Введите промокод или нажмите “Применить”, чтобы удалить текущий';
                return;
            }

            checkPromoBtn.disabled = true;
            checkPromoBtn.textContent = 'Проверка...';

            try {
                const response = await fetch(`/api/promo-code/check?code=${encodeURIComponent(code)}&amount=${encodeURIComponent(subtotalValue)}`);
                const data = await response.json();

                if (data.valid) {
                    promoResult.className = 'promo-result success';
                    promoResult.textContent = `Промокод подходит. Скидка: ${data.discount_text}`;

                    const discountAmount = data.discount_amount || 0;
                    discountEl.textContent = number_format(discountAmount, 2, '.', ' ') + ' ₽';
                    totalEl.textContent = number_format(Math.max(0, subtotalValue - discountAmount), 2, '.', ' ') + ' ₽';
                } else {
                    promoResult.className = 'promo-result error';
                    promoResult.textContent = data.message || 'Промокод недействителен';
                }
            } catch (e) {
                promoResult.className = 'promo-result error';
                promoResult.textContent = 'Ошибка при проверке промокода';
            } finally {
                checkPromoBtn.disabled = false;
                checkPromoBtn.textContent = 'Проверить';
            }
        });
    </script>
</body>
</html>

