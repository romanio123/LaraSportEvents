<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" style="color: white; text-decoration: none;">SportEvents</a>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Главная</a></li>
            <li><a href="{{ route('events.index') }}">Мероприятия</a></li>
            <li><a href="{{ route('support') }}">Поддержка</a></li>
            @auth
                @if(auth()->user()->role == 'admin')
                    <li><a href="{{ route('admin.index') }}">Админ-панель</a></li>
                @endif
                @if(auth()->user()->is_organizer)
                    <li><a href="{{ route('organizer.dashboard') }}">Панель организатора</a></li>
                @endif
            @endauth
        </ul>
        <div class="auth-buttons">
            @auth
                <a href="{{ route('profile') }}" class="btn btn-icon" title="Профиль">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="5"></circle>
                        <path d="M20 21a8 8 0 1 0-16 0"></path>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Вход</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
            @endauth
        </div>
    </nav>
</header>
