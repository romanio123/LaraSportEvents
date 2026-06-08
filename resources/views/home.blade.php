@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- Hero секция на всю ширину -->
<section class="hero-section full-width" style="background-image: url('{{ asset('images/banner.png') }}');">
    <div class="hero-overlay"></div>
    <div class="hero-content-wrapper">
        <div class="hero-content">
            <h1 class="hero-title">
                Добро пожаловать в <span class="gradient-text">SportEvents</span>
            </h1>
            <p class="hero-subtitle">
                Платформа для организации и поиска спортивных мероприятий. 
                Присоединяйтесь к нам и находите единомышленников!
            </p>
            <div class="hero-buttons">
                <a href="{{ route('events.index') }}" class="btn-primary-custom">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Все мероприятия
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn-secondary-custom">
                        <i class="fas fa-user-plus me-2"></i>
                        Присоединиться
                    </a>
                @endguest
                @auth
                    @if(Auth::user()->is_organizer)
                        <a href="{{ route('organizer.events.create') }}" class="btn-secondary-custom">
                            <i class="fas fa-plus-circle me-2"></i>
                            Создать мероприятие
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Остальной контент -->
<div class="container">
    <!-- Статистика -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-number">{{ $totalEvents ?? 0 }}</div>
                <div class="stat-label">Мероприятий</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                <div class="stat-label">Участников</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-number">{{ $totalCities ?? 0 }}</div>
                <div class="stat-label">Городов</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-number">{{ $totalCategories ?? 0 }}</div>
                <div class="stat-label">Категорий</div>
            </div>
        </div>
    </section>

    <!-- Ближайшие мероприятия -->
    <section class="upcoming-section">
        <div class="section-header">
            <h2 class="section-title">Ближайшие мероприятия</h2>
            <p class="section-subtitle">Не пропустите самые интересные события</p>
        </div>
        <div class="upcoming-grid">
            @forelse($upcomingEvents ?? [] as $event)
                <div class="upcoming-card">
                    <div class="upcoming-date">
                        <div class="date-day">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                        <div class="date-month">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('M') }}</div>
                    </div>
                    <div class="upcoming-info">
                        <h4 class="upcoming-title">{{ $event->title }}</h4>
                        <div class="upcoming-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->city }}</span>
                        </div>
                    </div>
                    <a href="{{ route('events.show', $event->id) }}" class="upcoming-link">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            @empty
                <div class="no-events">
                    <i class="fas fa-calendar-times fa-3x"></i>
                    <p>Скоро здесь появятся новые мероприятия</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Преимущества -->
    <section class="features-section">
        <div class="section-header">
            <h2 class="section-title">Почему выбирают нас?</h2>
            <p class="section-subtitle">Мы создали лучшую платформу для спортивных мероприятий</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="feature-title">Удобный поиск</h3>
                <p class="feature-description">Легко находите мероприятия по городу, дате и категории</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="feature-title">Быстрая регистрация</h3>
                <p class="feature-description">Запись на мероприятия в один клик</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Статистика</h3>
                <p class="feature-description">Отслеживайте свои достижения и прогресс</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="feature-title">Безопасность</h3>
                <p class="feature-description">Проверенные организаторы и надежная система</p>
            </div>
        </div>
    </section>
</div>

<!-- CTA секция на всю ширину -->
<section class="cta-section full-width">
    <div class="cta-content-wrapper">
        <div class="cta-content">
            <h2 class="cta-title">Готовы стать частью спортивного сообщества?</h2>
            <p class="cta-text">Присоединяйтесь к тысячам спортсменов и организаторов</p>
            <div class="cta-buttons">
                @guest
                    <a href="{{ route('register') }}" class="btn-primary-custom btn-lg">
                        <i class="fas fa-user-plus me-2"></i>
                        Зарегистрироваться
                    </a>
                @endguest
                <a href="{{ route('events.index') }}" class="btn-outline-custom btn-lg">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Посмотреть мероприятия
                </a>
            </div>
        </div>
    </div>
</section>
@endsection