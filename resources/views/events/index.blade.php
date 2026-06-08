@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-tables.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="container mt-4">
    <div class="events-header mb-4">
        <h1 class="events-title">Все мероприятия</h1>
        <p class="events-subtitle">Найдите подходящее спортивное событие и присоединяйтесь к нам!</p>
    </div>

    <!-- Блок фильтрации -->
<div class="filters-section">
    <div class="filters-wrapper">
        <div class="filter-group">
            <button class="filter-btn {{ !request('category') || request('category') == 'all' ? 'active' : '' }}" data-category="all">
                <i class="fas fa-th-large me-2"></i>
                Все
            </button>
            <button class="filter-btn {{ request('category') == 'football' ? 'active' : '' }}" data-category="football">
                <i class="fas fa-futbol me-2"></i> Футбол
            </button>
            <button class="filter-btn {{ request('category') == 'basketball' ? 'active' : '' }}" data-category="basketball">
                <i class="fas fa-basketball-ball me-2"></i> Баскетбол
            </button>
            <button class="filter-btn {{ request('category') == 'volleyball' ? 'active' : '' }}" data-category="volleyball">
                <i class="fas fa-volleyball-ball me-2"></i> Волейбол
            </button>
            <button class="filter-btn {{ request('category') == 'tennis' ? 'active' : '' }}" data-category="tennis">
                <i class="fas fa-table-tennis me-2"></i> Теннис
            </button>
            <button class="filter-btn {{ request('category') == 'swimming' ? 'active' : '' }}" data-category="swimming">
                <i class="fas fa-swimmer me-2"></i> Плавание
            </button>
            <button class="filter-btn {{ request('category') == 'yoga' ? 'active' : '' }}" data-category="yoga">
                <i class="fas fa-praying-hands me-2"></i> Йога
            </button>
            <button class="filter-btn {{ request('category') == 'running' ? 'active' : '' }}" data-category="running">
                <i class="fas fa-running me-2"></i> Бег
            </button>
            <button class="filter-btn {{ request('category') == 'cycling' ? 'active' : '' }}" data-category="cycling">
                <i class="fas fa-bicycle me-2"></i> Велоспорт
            </button>
            <button class="filter-btn {{ request('category') == 'fitness' ? 'active' : '' }}" data-category="fitness">
                <i class="fas fa-heartbeat me-2"></i> Фитнес
            </button>
            <button class="filter-btn {{ request('category') == 'boxing' ? 'active' : '' }}" data-category="boxing">
                <i class="fas fa-fist-raised me-2"></i> Бокс
            </button>
            <button class="filter-btn {{ request('category') == 'workout' ? 'active' : '' }}" data-category="workout">
                <i class="fas fa-dumbbell me-2"></i> Воркаут
            </button>
            <button class="filter-btn {{ request('category') == 'crossfit' ? 'active' : '' }}" data-category="crossfit">
                <i class="fas fa-bolt me-2"></i> Кроссфит
            </button>
            <button class="filter-btn {{ request('category') == 'dancing' ? 'active' : '' }}" data-category="dancing">
                <i class="fas fa-music me-2"></i> Танцы
            </button>
            <button class="filter-btn {{ request('category') == 'martial_arts' ? 'active' : '' }}" data-category="martial_arts">
                <i class="fas fa-shield-alt me-2"></i> Единоборства
            </button>
            <button class="filter-btn {{ request('category') == 'skiing' ? 'active' : '' }}" data-category="skiing">
                <i class="fas fa-skiing me-2"></i> Лыжи
            </button>
            <button class="filter-btn {{ request('category') == 'hockey' ? 'active' : '' }}" data-category="hockey">
                <i class="fas fa-hockey-puck me-2"></i> Хоккей
            </button>
            <button class="filter-btn {{ request('category') == 'other' ? 'active' : '' }}" data-category="other">
                <i class="fas fa-sports me-2"></i> Другое
            </button>
        </div>
        
        <div class="filter-search">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Поиск по названию или городу..." value="{{ request('search') }}">
                @if(request('search'))
                    <a href="{{ route('events.index') }}" class="search-clear" title="Очистить">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

    <!-- Результаты фильтрации -->
    <div class="events-count" id="eventsCount">
        Найдено мероприятий: <span id="countValue">{{ $events->count() }}</span>
    </div>

    <!-- Сетка карточек -->

<div class="events-grid" id="eventsGrid">
    @foreach($events as $event)
        <div class="event-card" 
             data-id="{{ $event->id }}"
             data-title="{{ $event->title }}"
             data-category="{{ $event->category }}"
             data-city="{{ $event->city }}">
            
            <div class="event-image">
                @if($event->image && Storage::disk('public')->exists($event->image))
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                @else
                    <div class="event-image-placeholder">
                        <i class="fas fa-calendar-alt fa-4x"></i>
                    </div>
                @endif
                <div class="event-category-badge">
                    <i class="fas 
                        @if($event->category == 'Футбол') fa-futbol
                        @elseif($event->category == 'Баскетбол') fa-basketball-ball
                        @elseif($event->category == 'Волейбол') fa-volleyball-ball
                        @elseif($event->category == 'Теннис') fa-table-tennis
                        @elseif($event->category == 'Плавание') fa-swimmer
                        @elseif($event->category == 'Йога') fa-praying-hands
                        @elseif($event->category == 'Бег') fa-running
                        @elseif($event->category == 'Велоспорт') fa-bicycle
                        @elseif($event->category == 'Фитнес') fa-heartbeat
                        @elseif($event->category == 'Бокс') fa-fist-raised
                        @else fa-sports
                        @endif
                    "></i>
                    {{ $event->category }}
                </div>
            </div>
            
            <div class="event-content">
                <h3 class="event-title">{{ $event->title }}</h3>
                
                <div class="event-details">
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $event->city }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $event->current_participants }}/{{ $event->max_participants }}</span>
                    </div>
                </div>
                
                <p class="event-description">{{ Str::limit($event->description, 80) }}</p>
            </div>
            
            <div class="event-footer">
                <div class="event-price">
                    @if($event->price > 0)
                        <span class="price-value">{{ number_format($event->price, 0, ',', ' ') }} ₽</span>
                    @else
                        <span class="price-free">Бесплатно</span>
                    @endif
                </div>
                <a href="{{ route('events.show', $event->id) }}" class="event-btn">
                    Подробнее
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    @endforeach
</div>

    @if ($events->hasPages())
    <div class="custom-pagination">
        {{-- Previous --}}
        @if ($events->onFirstPage())
            <span class="disabled">←</span>
        @else
            <a href="{{ $events->previousPageUrl() }}" class="page-nav">←</a>
        @endif

        {{-- Номера страниц --}}
        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
            @if ($page == $events->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if ($events->hasMorePages())
            <a href="{{ $events->nextPageUrl() }}" class="page-nav">→</a>
        @else
            <span class="disabled">→</span>
        @endif
    </div>
@endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    
    function filterEvents() {
        const url = new URL(window.location.href);
        let activeCategory = null;
        
        // Находим активную категорию
        filterBtns.forEach(btn => {
            if (btn.classList.contains('active')) {
                activeCategory = btn.getAttribute('data-category');
            }
        });
        
        // Устанавливаем параметры URL
        if (activeCategory && activeCategory !== 'all') {
            url.searchParams.set('category', activeCategory);
        } else {
            url.searchParams.delete('category');
        }
        
        if (searchInput && searchInput.value) {
            url.searchParams.set('search', searchInput.value);
        } else {
            url.searchParams.delete('search');
        }
        
        window.location.href = url.toString();
    }
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterEvents();
        });
    });
    
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => filterEvents(), 500);
        });
    }
});
</script>
@endsection