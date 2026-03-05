<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Покупатели - Админ панель</title>
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
                        <a href="{{ route('admin.customers.index') }}" class="nav-link active">Покупатели</a>
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
                <div class="header">
                    <h1 class="page-title">Покупатели</h1>
                </div>

                <div class="filters">
                    <form method="GET" action="{{ route('admin.customers.index') }}">
                        <input type="text" name="search" placeholder="Поиск по имени, email, телефону..." value="{{ request('search') }}" style="flex: 1; min-width: 200px;">
                        <select name="activity_type">
                            <option value="">Все виды деятельности</option>
                            <option value="podologist" {{ request('activity_type') === 'podologist' ? 'selected' : '' }}>Подолог</option>
                            <option value="aesthetician" {{ request('activity_type') === 'aesthetician' ? 'selected' : '' }}>Эстетист</option>
                            <option value="manager" {{ request('activity_type') === 'manager' ? 'selected' : '' }}>Руководитель</option>
                        </select>
                        <button type="submit">Фильтровать</button>
                    </form>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Email</th>
                                <th>Вид деятельности</th>
                                <th>Количество заказов</th>
                                <th>Дата регистрации</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td><strong>{{ $customer->last_name }}</strong></td>
                                    <td>{{ $customer->first_name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->activity_type_label }}</td>
                                    <td><strong>{{ $customer->orders_count }}</strong></td>
                                    <td>{{ $customer->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2rem;">Покупатели не найдены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ asset('assets/js/matrix.js') }}" defer></script>
</body>
</html>

