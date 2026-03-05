<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="auth-page">
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

        <main class="auth-main">
            <div class="auth-card">
                <h1 class="auth-title">Вход в админ-панель</h1>
                <p class="auth-subtitle">Управление заказами, билетами и промокодами</p>

                @if($errors->any())
                    <div class="errors">
                        <strong>Ошибка входа:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="input"
                            value="{{ old('email', 'admin@eventgo.ru') }}"
                            placeholder="admin@eventgo.ru"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 0.6rem;">
                        <label for="password">Пароль</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="input"
                            value="{{ config('app.env') === 'local' ? 'admin123' : '' }}"
                            placeholder="Введите пароль"
                            required
                        >
                    </div>

                    <div class="form-footer" style="margin-bottom: 1.2rem;">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Запомнить меня</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth">
                        Войти
                    </button>
                </form>

                <div class="auth-helper">
                    Тестовый доступ: <code>admin@eventgo.ru / admin123</code><br>
                    (после запуска проекта рекомендуется сменить пароль)
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/backgraund.js') }}" defer></script>
    <script src="{{ asset('assets/js/matrix.js') }}" defer></script>
</body>
</html>

