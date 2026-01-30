@extends('layouts.app')


@section('content')
    <div class="profile-container">
        <div class="profile-main">

            <div class="profile-content">
                <div class="profile-header">
                    @if($user->id == 1)
                        <h1 class="profile-name-admin">{{ $user->name }}</h1>
                    @else
                        <h1 class="profile-name">{{ $user->name }}</h1>
                    @endif
                    <div class="profile-divider"></div>
                </div>

                <div class="profile-section">
                    <h2 class="section-title">Личные данные</h2>

                    <div class="data-grid">

                        <div class="data-row">
                            <div class="data-label">
                                <span>Имя</span>
                            </div>
                            <div class="data-value">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span>Электронная почта</span>
                            </div>
                            <div class="data-value">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span>Роль</span>
                            </div>
                            <div class="data-value">
                                @if($user->role == 'admin')
                                    <span class="admin">Администратор</span>
                                @elseif($user->role == 'organizer')
                                    <span class="organizer">Организатор</span>
                                @else
                                    <span class="user">Пользователь</span>
                                @endif
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span>Статус организатора</span>
                            </div>
                            <div class="data-value">
                                @if($user->is_organizer)
                                    <span class="status-badge active">Да</span>
                                @else
                                    <span class="status-badge inactive">Нет</span>
                                @endif
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span>Дата регистрации</span>
                            </div>
                            <div class="data-value">
                                {{ $user->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span>Последнее обновление</span>
                            </div>
                            <div class="data-value">
                                {{ $user->updated_at->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-right: 10px;">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Выйти
                            </button>
                        </form>

                    </div>

                    @if($user->is_organizer || $user->role == 'admin')
                        <div class="stats-section">
                            <h3 class="section-title">Статистика</h3>
                            <div class="stats-grid">
                                @if($user->is_organizer)
                                    <div class="stat-card">
                                        <div class="stat-icon">📅</div>
                                        <div class="stat-content">
                                            <div class="stat-number">{{ $eventsCount ?? 0 }}</div>
                                            <div class="stat-label">Мероприятий создано</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="stat-card">
                                    <div class="stat-icon">👥</div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ $participantsCount ?? 0 }}</div>
                                        <div class="stat-label">Участников мероприятий</div>
                                    </div>
                                </div>

                                @if($user->role == 'admin')
                                    <div class="stat-card">
                                        <div class="stat-icon">👑</div>
                                        <div class="stat-content">
                                            <div class="stat-number">{{ $adminsCount ?? 0 }}</div>
                                            <div class="stat-label">Администраторов</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
