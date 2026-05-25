<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - {{ $ticket->name }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-set.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/order-form.css') }}">
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <div class="container">
            <div class="order-card" data-ticket-price="{{ $ticket->price }}">
                <div class="order-header">
                    <h1>ОФОРМЛЕНИЕ ЗАКАЗА</h1>
                    <div class="ticket-type">{{ $ticket->type === 'vip' ? 'VIP' : 'ОБЫЧНЫЙ' }}</div>
                </div>

                <div class="order-content">
                    <div class="ticket-summary">
                        <div class="ticket-summary-row">
                            <span>Билет:</span>
                            <span><strong>{{ $ticket->name }}</strong></span>
                        </div>
                        <div class="ticket-summary-row">
                            <span>Цена за единицу:</span>
                            <span>{{ number_format($ticket->price, 2, '.', ' ') }} ₽</span>
                        </div>
                        <div class="ticket-summary-row">
                            <span>Доступно:</span>
                            <span>{{ $ticket->available_quantity }} шт.</span>
                        </div>
                        <div class="ticket-summary-row" id="total-row">
                            <span>Итого:</span>
                            <span id="total-amount">{{ number_format($ticket->price, 2, '.', ' ') }} ₽</span>
                        </div>
                    </div>

                    <form action="{{ route('orders.create') }}" method="POST" id="order-form">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">Имя *</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">Фамилия *</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Телефон *</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="89094368010" required>
                                @error('phone')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="activity_type">Вид деятельности *</label>
                            <select id="activity_type" name="activity_type" required>
                                <option value="">Выберите вид деятельности</option>
                                <option value="podologist" {{ old('activity_type') === 'podologist' ? 'selected' : '' }}>Подолог</option>
                                <option value="aesthetician" {{ old('activity_type') === 'aesthetician' ? 'selected' : '' }}>Эстетист</option>
                                <option value="manager" {{ old('activity_type') === 'manager' ? 'selected' : '' }}>Руководитель</option>
                            </select>
                            @error('activity_type')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="quantity">Количество билетов *</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $ticket->available_quantity }}" required>
                            @error('quantity')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="payment-yookassa-note">Оплата — через платёжную систему <strong>ЮKassa</strong> после оформления заказа.</p>

                        <div class="checkbox-group">
                            <input type="checkbox" id="personal_data_agreement" name="personal_data_agreement" value="1" {{ old('personal_data_agreement') ? 'checked' : '' }} required>
                            <label for="personal_data_agreement">
                                Я ознакомлен(а) с <a href="{{ route('pages.agreement') }}" target="_blank" rel="noopener noreferrer" class="agreement-inline-link">пользовательским соглашением и политикой обработки персональных данных</a> и даю согласие на обработку моих персональных данных *
                            </label>
                        </div>
                        @error('personal_data_agreement')
                            <div class="error-message">{{ $message }}</div>
                        @enderror

                        @if($errors->any())
                            <div class="form-errors-summary error-message">
                                <strong>Ошибки при заполнении формы:</strong>
                                <ul class="form-errors-summary-list">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" class="btn">ОФОРМИТЬ ЗАКАЗ</button>
                    </form>

                    <a href="{{ route('index') }}" class="back-link">← Вернуться на главную</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}"></script>
    <script src="{{ asset('assets/js/matrix.js') }}"></script>
    <script src="{{ asset('assets/js/order-form.js') }}"></script>
</body>
</html>
