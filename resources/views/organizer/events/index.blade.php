@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/organizer.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="organizer-events-page">
    <div class="container"> 
        <div class="events-header mb-4">
            <div class="mb-4">
                <h1 class="events-title">Мои мероприятия</h1>
                <p class="events-subtitle">Управляйте своими спортивными событиями</p>
            </div>

            <a href="{{ route('organizer.events.create') }}" class="btn-create">
                <i class="fas fa-plus me-2"></i>
                Создать мероприятие
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        <!-- Статистика -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $events->total() ?? 0 }}</div>
                    <div class="stat-label">Всего мероприятий</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $eventsTotal ?? 0 }}</div>
                    <div class="stat-label">Предстоящих</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $events->sum('current_participants') ?? 0 }}</div>
                    <div class="stat-label">Всего участников</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ number_format($events->sum('price') ?? 0, 0, ',', ' ') }} ₽</div>
                    <div class="stat-label">Общий доход</div>
                </div>
            </div>
        </div>

        <!-- Таблица мероприятий -->
        @if($events->isNotEmpty())
            <div class="table-container">
                <div class="table-header">
                    <h3><i class="fas fa-list me-2"></i>Список мероприятий</h3>
                    <div class="table-controls">
                        <!-- Поиск -->
                        <div class="search-wrapper">
                            <form method="GET" action="{{ route('organizer.events.index') }}" class="search-form">
                                <div class="search-input-group">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" 
                                           name="search" 
                                           class="search-input" 
                                           placeholder="Поиск по названию..." 
                                           value="{{ request('search') }}">
                                    @if(request('search'))
                                        <a href="{{ route('organizer.events.index') }}" class="search-clear" title="Очистить">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                                <button type="submit" class="search-btn">Найти</button>
                            </form>
                        </div>
                        <div class="table-info">
                            <i class="fas fa-info-circle"></i>
                            Найдено: {{ $events->total() }} мероприятий
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="events-table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Дата</th>
                                <th>Город</th>
                                <th>Цена</th>
                                <th>Участники</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td class="event-title">
                                        <strong>{{ $event->title }}</strong>
                                    </td>
                                    <td class="event-date">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $event->date->format('d.m.Y') }}
                                        <span class="event-time">{{ $event->date->format('H:i') }}</span>
                                    </td>
                                    <td class="event-city">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $event->city }}
                                    </td>
                                    <td class="event-price">
                                        @if($event->price > 0)
                                            <span class="price-value">{{ number_format($event->price, 0, ',', ' ') }} ₽</span>
                                        @else
                                            <span class="price-free">Бесплатно</span>
                                        @endif
                                    </td>
                                    <td class="event-participants">
                                        <div class="participants-info">
                                            <span class="participants-count">{{ $event->current_participants }}/{{ $event->max_participants }}</span>
                                            <div class="progress-bar-small">
                                                @php
                                                    $percent = $event->max_participants > 0 ? ($event->current_participants / $event->max_participants) * 100 : 0;
                                                @endphp
                                                <div class="progress-fill" style="width: {{ $percent }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="event-status">
                                        @if($event->hasAvailableSlots())
                                            <span class="status-badge available">
                                                <i class="fas fa-check-circle"></i> Есть места
                                            </span>
                                        @else
                                            <span class="status-badge full">
                                                <i class="fas fa-times-circle"></i> Заполнено
                                            </span>
                                        @endif
                                    </td>
                                    <td class="event-actions">
                                        <div class="action-buttons">
                                            <a href="{{ route('events.show', $event->id) }}" class="action-btn view" title="Просмотр">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('organizer.events.edit', $event->id) }}" class="action-btn edit" title="Редактировать">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить мероприятие «{{ $event->title }}»?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Удалить">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Пагинация -->
                @if ($events->hasPages())
                    <div class="custom-pagination">
                        @if ($events->onFirstPage())
                            <span class="disabled"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $events->previousPageUrl() }}" class="page-nav">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                            @if ($page == $events->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($events->hasMorePages())
                            <a href="{{ $events->nextPageUrl() }}" class="page-nav">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="disabled"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                    
                    <div class="pagination-info">
                        Показано с {{ $events->firstItem() }} по {{ $events->lastItem() }} 
                        из {{ $events->total() }} мероприятий
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                @if(request('search'))
                    <h3>Ничего не найдено</h3>
                    <p>Мероприятий с названием "{{ request('search') }}" не найдено</p>
                    <a href="{{ route('organizer.events.index') }}" class="btn-create-large">
                        <i class="fas fa-arrow-left me-2"></i>
                        Вернуться к списку
                    </a>
                @else
                    <h3>У вас пока нет мероприятий</h3>
                    <p>Создайте свое первое мероприятие и привлекайте участников</p>
                    <a href="{{ route('organizer.events.create') }}" class="btn-create-large">
                        <i class="fas fa-plus me-2"></i>
                        Создать первое мероприятие
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection