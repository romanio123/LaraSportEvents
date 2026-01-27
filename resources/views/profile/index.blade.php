@extends('layouts.app')


@section('content')
    <div class="profile-container">
        <div class="profile-main">

            <div class="profile-content">
                <div class="profile-header">
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    <div class="profile-divider"></div>
                </div>

                <div class="profile-section">
                    <h2 class="section-title">Личные данные</h2>

                    <div class="data-grid">

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">1</span>
                                <span>Имя</span>
                            </div>
                            <div class="data-value">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">2</span>
                                <span>Электронная почта</span>
                            </div>
                            <div class="data-value">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">3</span>
                                <span>Роль</span>
                            </div>
                            <div class="data-value">
                                @if($user->role == 'admin')
                                    <span class="role-badge admin">Администратор</span>
                                @elseif($user->role == 'organizer')
                                    <span class="role-badge organizer">Организатор</span>
                                @else
                                    <span class="role-badge user">Пользователь</span>
                                @endif
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">4</span>
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
                                <span class="data-number">5</span>
                                <span>ID пользователя</span>
                            </div>
                            <div class="data-value">
                                {{ $user->id }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">6</span>
                                <span>Дата регистрации</span>
                            </div>
                            <div class="data-value">
                                {{ $user->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">7</span>
                                <span>Последнее обновление</span>
                            </div>
                            <div class="data-value">
                                {{ $user->updated_at->format('d.m.Y H:i') }}
                            </div>
                        </div>

                        @if(isset($user->city) && $user->city)
                            <div class="data-row">
                                <div class="data-label">
                                    <span class="data-number">9</span>
                                    <span>Город</span>
                                </div>
                                <div class="data-value">
                                    {{ $user->city }}
                                </div>
                            </div>
                        @endif

                        <div class="data-row">
                            <div class="data-label">
                                <span class="data-number">10</span>
                                <span>Управление аккаунтом</span>
                            </div>
                            <div class="data-value">
                                <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-right: 10px;">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fas fa-sign-out-alt"></i> Выйти
                                    </button>
                                </form>

                            </div>
                        </div>
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
