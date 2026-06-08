@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush

@section('content')
@auth

<div class="container mt-4">
    <div class="events-header mb-4">
        <h1 class="events-title">Профиль</h1>
        <p class="events-subtitle">Управляйте личными данными и отслеживайте участие в мероприятиях</p>
    </div>

    <!-- Информация о пользователе -->
    <div class="profile-header">
        <div class="profile-avatar-section">
    <div class="profile-avatar-wrapper">
        @if(Auth::user()->avatar && Storage::disk('public')->exists(Auth::user()->avatar))
            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" class="profile-avatar-img">
        @else
            <div class="profile-avatar-placeholder">
                <i class="fas fa-user"></i>
            </div>
        @endif
        
        <!-- Кнопка загрузки аватарки -->
        <label for="avatar-upload" class="avatar-upload-btn">
            <i class="fas fa-camera"></i>
        </label>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form" style="display: none;">
            @csrf
            @method('PUT')
            <input type="file" id="avatar-upload" name="avatar" accept="image/*" onchange="this.form.submit()">
        </form>
        
        <!-- Кнопка удаления аватарки -->
        @if(Auth::user()->avatar && Storage::disk('public')->exists(Auth::user()->avatar))
            <form action="{{ route('profile.avatar.delete') }}" method="POST" class="avatar-delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="avatar-delete-btn" onclick="return confirm('Удалить аватарку?')" title="Удалить аватарку">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        @endif
    </div>
    <p class="avatar-hint">Нажмите на камеру, чтобы загрузить фото</p>
</div>

        <div class="profile-info">
            <h1>{{ Auth::user()->name }}</h1>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            <div class="profile-badges">
                <span class="badge {{ Auth::user()->role == 'admin' ? 'badge-admin' : 'badge-user' }}">
                    {{ Auth::user()->role == 'admin' ? 'Администратор' : 'Пользователь' }}
                </span>
                @if(Auth::user()->is_organizer)
                    <span class="badge badge-organizer">Организатор</span>
                @endif
            </div>
        </div>
        
        <div class="profile-actions">
            <a href="{{ route('user.edit') }}" class="btn btn-outline-primary">
                <i class="fas fa-edit"></i> Редактировать
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </button>
            </form>
        </div>
    </div>

    <!-- Статистика -->
    <div class="profile-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-number">{{ isset($registeredEvents) ? $registeredEvents->total() : 0 }}</div>
            <div class="stat-label">Мероприятий запланировано</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number">{{ $completedEvents ?? 0 }}</div>
            <div class="stat-label">Пройденных мероприятий</div>
        </div>
        @if(Auth::user()->is_organizer)
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="stat-number">{{ $myEventsCount ?? 0 }}</div>
            <div class="stat-label">Моих мероприятий</div>
        </div>
        @endif
    </div>

    <!-- Мои мероприятия (на которые зарегистрирован) -->
    <div class="profile-section">
        <div class="section-header">
            <h2><i class="fas fa-calendar-check me-2"></i>Мои мероприятия</h2>
            <a href="{{ route('events.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Найти мероприятия
            </a>
        </div>

        @if(isset($registeredEvents) && $registeredEvents->isEmpty())
            <div class="empty-state">
                <i class="fas fa-calendar-times fa-3x"></i>
                <h3>Вы еще не зарегистрированы ни на одно мероприятие</h3>
                <p>Перейдите в каталог мероприятий и выберите событие для участия</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-search me-2"></i>Посмотреть мероприятия
                </a>
            </div>
        @elseif(isset($registeredEvents))
            <div class="events-grid">
                @foreach($registeredEvents as $event)
                    <div class="event-card">
                        <div class="event-image">
                            @if($event->image && Storage::disk('public')->exists($event->image))
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                            @else
                                <div class="event-image-placeholder">
                                    <i class="fas fa-calendar-alt fa-3x"></i>
                                </div>
                            @endif
                            <div class="event-status-badge">
                                @if(\Carbon\Carbon::parse($event->date)->isPast())
                                    <span class="status-completed">Завершено</span>
                                @else
                                    <span class="status-upcoming">Предстоит</span>
                                @endif
                            </div>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <div class="event-details">
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $event->city }}, {{ $event->location }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $event->current_participants }}/{{ $event->max_participants }} участников</span>
                                </div>
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
                    </div>
                @endforeach
            </div>
            <!-- Пагинация для зарегистрированных мероприятий -->
            @if(isset($registeredEvents) && $registeredEvents->hasPages())
                <div class="custom-pagination">
                    @if ($registeredEvents->onFirstPage())
                        <span class="disabled"><i class="fas fa-chevron-left"></i></span>
                    @else
                        <a href="{{ $registeredEvents->previousPageUrl() }}" class="page-nav">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach ($registeredEvents->getUrlRange(1, $registeredEvents->lastPage()) as $page => $url)
                        @if ($page == $registeredEvents->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($registeredEvents->hasMorePages())
                        <a href="{{ $registeredEvents->nextPageUrl() }}" class="page-nav">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="disabled"><i class="fas fa-chevron-right"></i></span>
                    @endif
                </div>
            @endif
        @endif
    </div>

    <!-- Созданные мероприятия (если пользователь организатор) -->
    @if(Auth::user()->is_organizer)
    <div class="profile-section">
        <div class="section-header">
            <h2><i class="fas fa-calendar-plus me-2"></i>Мои созданные мероприятия</h2>
            <a href="{{ route('organizer.events.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Создать мероприятие
            </a>
        </div>

        @if(isset($myEvents) && $myEvents->isEmpty())
            <div class="empty-state small">
                <i class="fas fa-calendar-alt fa-2x"></i>
                <p>Вы еще не создали ни одного мероприятия</p>
            </div>
        @elseif(isset($myEvents))
            <div class="events-grid">
                @foreach($myEvents as $event)
                    <div class="event-card">
                        <div class="event-image">
                            @if($event->image && Storage::disk('public')->exists($event->image))
                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                            @else
                                <div class="event-image-placeholder">
                                    <i class="fas fa-calendar-alt fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <div class="event-details">
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y H:i') }}</span>
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif
</div>
@else
<div class="container mt-4">
    <div class="alert alert-warning text-center">
        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
        <h3>Вы не авторизованы</h3>
        <p>Пожалуйста, <a href="{{ route('login') }}">войдите</a> в систему для просмотра профиля</p>
    </div>
</div>
@endauth
@endsection