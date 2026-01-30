<header class="site-header">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="{{ route('home') }}" class="nav-logo">SportEvents</a>
            </div>

            <button class="nav-toggle" aria-label="Меню">
                <i class="fas fa-bars"></i>
            </button>

            <div class="nav-content">
                <ul class="nav-links">
                    <li>
                        <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <span>Мероприятия</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('support') }}" class="nav-link {{ request()->routeIs('support') ? 'active' : '' }}">
                            <i class="fas fa-headset nav-icon"></i>
                            <span>Поддержка</span>
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <li>
                                <a href="{{ route('admin.index') }}" class="nav-link nav-link-admin {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                                    <i class="fas fa-crown nav-icon"></i>
                                    <span>Админ-панель</span>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->is_organizer)
                            <li>
                                <a href="{{ route('organizer.dashboard') }}" class="nav-link nav-link-organizer {{ request()->routeIs('organizer.*') ? 'active' : '' }}">
                                    <i class="fas fa-chart-line nav-icon"></i>
                                    <span>Организатор</span>
                                </a>
                            </li>
                            @endif
                    @endauth
                </ul>

                <div class="nav-auth">
                    @auth
                        <a href="{{ route('profile') }}" class="profile-btn" title="Профиль">
                            <div class="profile-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="auth-btn auth-btn-outline">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Вход</span>
                        </a>
                        <a href="{{ route('register') }}" class="auth-btn auth-btn-primary">
                            <i class="fas fa-user-plus"></i>
                            <span>Регистрация</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
