<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Билеты - Админ панель</title>
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
                        <a href="{{ route('admin.tickets.index') }}" class="nav-link active">Билеты</a>
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
                <div class="header">
                    <h1 class="page-title">Билеты</h1>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Тип</th>
                                <th>Цена</th>
                                <th>Доступно</th>
                                <th>Продано</th>
                                <th>Статус</th>
                                <th>Дата создания</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td><strong>{{ $ticket->name }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $ticket->type === 'vip' ? 'vip' : 'regular' }}">
                                            {{ $ticket->type === 'vip' ? 'VIP' : 'Обычный' }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $ticket->formatted_price }}</strong></td>
                                    <td>{{ $ticket->available_quantity }}</td>
                                    <td><strong>{{ $ticket->orders_count }}</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $ticket->is_active ? 'active' : 'inactive' }}">
                                            {{ $ticket->is_active ? 'Активен' : 'Неактивен' }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2rem;">Билеты не найдены</td>
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

