<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы - Админ панель</title>
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
                        <a href="{{ route('admin.orders.index') }}" class="nav-link active">Заказы</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.customers.index') }}" class="nav-link">Покупатели</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.tickets.index') }}" class="nav-link">Билеты</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.promo_codes.index') }}" class="nav-link">Промокоды</a>
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
                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="header">
                    <h1 class="page-title">Заказы</h1>
                </div>

                <div class="filters">
                    <form method="GET" action="{{ route('admin.orders.index') }}">
                        <input type="text" name="search" placeholder="Поиск..." value="{{ request('search') }}">
                        <select name="status">
                            <option value="">Все статусы</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Ожидает оплаты</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Оплачен</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Ошибка</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Отменен</option>
                        </select>
                        <button type="submit">Фильтровать</button>
                    </form>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Номер заказа</th>
                                <th>Покупатель</th>
                                <th>Билет</th>
                                <th>Количество</th>
                                <th>Сумма</th>
                                <th>Статус</th>
                                <th>Чек</th>
                                <th>Билет</th>
                                <th>Email</th>
                                <th>Дата</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td><strong>{{ $order->order_number }}</strong></td>
                                    <td>{{ $order->customer->full_name }}<br><small>{{ $order->customer->email }}</small></td>
                                    <td>{{ $order->ticket->name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td><strong>{{ $order->formatted_total_amount }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ $order->payment_status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->payment_status === 'paid')
                                            @if($order->receipt_sent)
                                                <span class="badge badge-success">✓ Отправлен</span>
                                            @else
                                                <span class="badge badge-warning">Не отправлен</span>
                                            @endif
                                        @else
                                            <span class="badge badge-gray">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status === 'paid')
                                            @if($order->ticket_sent)
                                                <span class="badge badge-success">✓ Отправлен</span>
                                            @else
                                                <span class="badge badge-warning">Не отправлен</span>
                                            @endif
                                        @else
                                            <span class="badge badge-gray">—</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $order->customer->email }}</small></td>
                                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">Просмотр</a>
                                        @if($order->payment_status === 'pending')
                                            <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST" style="display: inline-block; margin-top: 0.5rem;">
                                                @csrf
                                                <button type="submit" class="btn btn-success" onclick="return confirm('Подтвердить оплату заказа №{{ $order->order_number }}? Чек и билет будут отправлены на email покупателя.')">Подтвердить оплату</button>
                                            </form>
                                            @if(abs($order->total_amount - 10.00) < 0.01)
                                            <form action="{{ route('admin.orders.test-check', $order->id) }}" method="POST" style="display: inline-block; margin-top: 0.5rem;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" style="font-size: 0.875rem;" onclick="return confirm('Тестовая проверка для заказа на 10₽?')">🧪 Тест</button>
                                            </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" style="text-align: center; padding: 2rem;">Заказы не найдены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ asset('assets/js/matrix.js') }}" defer></script>
</body>
</html>

