<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Промокоды - Админ панель</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>
    <canvas id="c"></canvas>
    <div id="matrix-background"></div>

    <div class="content-wrapper">
        <header class="admin-header">
            <div class="container">
                <div class="admin-header-inner">
                    <div class="logo">EVENTGO</div>
                    <div class="admin-header-links">
                        <a href="{{ url('/') }}" class="admin-header-link">НА САЙТ</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="admin-body">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h2>ADMIN</h2>
                </div>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link">Заказы</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="nav-link">Покупатели</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.tickets.index') }}" class="nav-link">Билеты</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.promo_codes.index') }}" class="nav-link active">Промокоды</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">Выход</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="main-content">
                <div class="header">
                    <h1 class="page-title">Промокоды</h1>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Код</th>
                                <th>Тип скидки</th>
                                <th>Значение</th>
                                <th>Использовано</th>
                                <th>Максимум</th>
                                <th>Действителен с</th>
                                <th>Действителен до</th>
                                <th>Статус</th>
                                <th>Использований</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promoCodes as $promoCode)
                                <tr>
                                    <td><strong style="font-family: monospace; font-size: 1.1rem;">{{ $promoCode->code }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $promoCode->discount_type === 'percentage' ? 'percentage' : 'fixed' }}">
                                            {{ $promoCode->discount_type === 'percentage' ? 'Процент' : 'Фиксированная' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $promoCode->discount_type === 'percentage' ? $promoCode->discount_value . '%' : number_format($promoCode->discount_value, 2, '.', ' ') . ' ₽' }}
                                        </strong>
                                    </td>
                                    <td>{{ $promoCode->used_count }}</td>
                                    <td>{{ $promoCode->max_uses ?? '∞' }}</td>
                                    <td>{{ $promoCode->valid_from ? $promoCode->valid_from->format('d.m.Y') : '—' }}</td>
                                    <td>{{ $promoCode->valid_until ? $promoCode->valid_until->format('d.m.Y') : '—' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $promoCode->is_active ? 'active' : 'inactive' }}">
                                            {{ $promoCode->is_active ? 'Активен' : 'Неактивен' }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $promoCode->orders_count }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 2rem;">Промокоды не найдены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ asset('assets/js/matrix.js') }}" defer></script>
</body>
</html>

