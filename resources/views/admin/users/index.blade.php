@extends('layouts.app')

@push('styles')
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-tables.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-4">
    <!-- Заголовок страницы -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Управление пользователями</h1>
            <p class="page-subtitle">Управление пользователями платформы: изменение ролей и прав</p>
        </div>
        <a href="{{ route('admin.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>
            Назад в панель
        </a>
    </div>

    <!-- Таблица пользователей -->
    <div class="table-container">
        <div class="table-header">
            <h3><i class="fas fa-users me-2"></i>Все пользователи</h3>
            <div class="table-info">
                <i class="fas fa-info-circle"></i>
                Всего пользователей: {{ $users->total() }}
            </div>
        </div>

        @if($users->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h3>Пользователей нет</h3>
                <p>В системе пока нет зарегистрированных пользователей</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Организатор</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="{{ $user->id == auth()->id() ? 'current-user-row' : '' }}">
                                <td class="table-id-cell">{{ $user->id }}</td>
                                <td class="table-title-cell">
                                    {{ $user->name }}
                                    @if($user->id == auth()->id())
                                        <span class="current-user-badge">(Это вы)</span>
                                    @endif
                                </td>
                                <td class="table-email-cell">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $user->email }}
                                </td>
                                <td class="table-role-cell">
                                    @if($user->id == auth()->id() || $user->id == 1)
                                        <div class="role-select disabled">
                                            <select disabled>
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>👤 Пользователь</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Администратор</option>
                                            </select>
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="role-form">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" onchange="this.closest('form').submit()">
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>👤 Пользователь</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Администратор</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td class="table-organizer-cell">
                                    @if($user->id != auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle-organizer', $user) }}" class="organizer-form">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="toggle-btn {{ $user->is_organizer ? 'active' : '' }}" 
                                                    title="{{ $user->is_organizer ? 'Отозвать права организатора' : 'Назначить организатором' }}">
                                                <span class="toggle-slider"></span>
                                                <span class="toggle-text">{{ $user->is_organizer ? 'Организатор' : 'Пользователь' }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="status-badge {{ $user->is_organizer ? 'available' : 'closed' }}">
                                            <i class="fas {{ $user->is_organizer ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                            {{ $user->is_organizer ? 'Организатор' : 'Пользователь' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="table-date-cell">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="table-actions-cell">
                                    @if($user->id != auth()->id() && $user->id != 1)
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                              onsubmit="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Удалить пользователя">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="action-btn delete disabled" disabled title="Нельзя удалить текущего пользователя">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            @if($users->hasPages())
                <div class="custom-pagination">
                    {{ $users->links() }}
                </div>
                <div class="pagination-info">
                    Показано с {{ $users->firstItem() }} по {{ $users->lastItem() }} 
                    из {{ $users->total() }} пользователей
                </div>
            @endif
        @endif
    </div>
</div>
@endsection