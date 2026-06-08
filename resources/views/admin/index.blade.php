@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-tables.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-4">
    <div class="events-header mb-4">
        <h1 class="events-title">Панель администратора</h1>
        <p class="events-subtitle">Управление платформой: пользователи, мероприятия и статистика в одном месте</p>
    </div>

    <!-- Статистика -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalParticipants ?? 0 }}</div>
                <div class="stat-label">Всего участников</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalEvents ?? 0 }}</div>
                <div class="stat-label">Всего мероприятий</div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="quick-actions-card">
        <div class="quick-actions-header">
            <h3 class="quick-actions-title">
                <i class="fas fa-bolt me-2"></i>
                Быстрые действия
            </h3>
            <p class="quick-actions-subtitle">Основные операции для управления платформой</p>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('admin.users.index') }}" class="quick-action-item">
                <div class="quick-action-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="quick-action-content">
                    <h4>Управление пользователями</h4>
                    <p>Добавление, редактирование, удаление</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>    

            <a href="{{ route('admin.support') }}" class="quick-action-item">
                <div class="quick-action-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="quick-action-content">
                    <h4>Поддержка</h4>
                    <p>Просмотр и управление обращениями</p>
                </div>
                <div class="quick-action-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Таблица последних пользователей -->
    <div class="table-container">
        <div class="table-header">
            <h3><i class="fas fa-users me-2"></i>Последние пользователи</h3>
            <div class="table-info">
                <i class="fas fa-info-circle"></i>
                Всего: {{ $recentUsers->count() }} пользователей
            </div>
        </div>

        @if($recentUsers->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h3>Нет пользователей</h3>
                <p>Зарегистрированные пользователи появятся здесь</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                            <tr>
                                <td class="table-title-cell">{{ $user->name }}</td>
                                <td class="table-email-cell">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <span class="status-badge {{ $user->role == 'admin' ? 'open' : 'confirmed' }}">
                                        <i class="fas {{ $user->role == 'admin' ? 'fa-crown' : 'fa-user' }}"></i>
                                        {{ $user->role == 'admin' ? 'Администратор' : 'Пользователь' }}
                                    </span>
                                    @if($user->is_organizer)
                                        <span class="status-badge available" style="margin-left: 0.25rem;">
                                            <i class="fas fa-calendar-alt"></i>
                                            Организатор
                                        </span>
                                    @endif
                                </td>
                                <td class="table-date-cell">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection