@extends('layouts.app')

@section('content')
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>Управление пользователями</h1>
            <a href="{{ route('admin.index') }}"
               style="padding: 0.75rem 1.5rem; background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
                color: white; text-decoration: none; border-radius: 8px;">
                ← Назад в панель
            </a>
        </div>

        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;">Все пользователи</h3>
                    <p style="color: #666;">Всего пользователей: {{ $users->total() }}</p>
                </div>
            </div>

            @if($users->isEmpty())
                <div style="text-align: center; padding: 3rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                    <h3 style="margin-bottom: 0.5rem;">Пользователей нет</h3>
                    <p style="color: #666;">В системе пока нет зарегистрированных пользователей</p>
                </div>
            @else

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #667eea;">
                                <th style="padding: 1rem; text-align: left;">ID</th>
                                <th style="padding: 1rem; text-align: left;">Имя</th>
                                <th style="padding: 1rem; text-align: left;">Email</th>
                                <th style="padding: 1rem; text-align: left;">Роль</th>
                                <th style="padding: 1rem; text-align: left;">Организатор</th>
                                <th style="padding: 1rem; text-align: left;">Дата регистрации</th>
                                <th style="padding: 1rem; text-align: left;">Действия</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #ffffff; {{ $user->id == auth()->id() ? 'background: #f9f9f9;' : ''}}
                            {{ $user->id == 1 ? 'background: rgba(255,5,5,0.05); color: red' : ''}}">
                                <td style="padding: 1rem;">{{ $user->id }}</td>
                                <td style="padding: 1rem;">
                                    <div style="font-weight: bold;">{{ $user->name }}</div>
                                    @if($user->id == auth()->id())
                                        <span style="color: #667eea; font-size: 12px;">
                                                (Это вы)
                                            </span>
                                    @endif

                                </td>
                                <td style="padding: 1rem;">{{ $user->email }}</td>
                                <td style="padding: 1rem;">

                                    @if($user->id == auth()->id() || $user->id == 1)
                                        <div style="display: inline-block; position: relative;">
                                            <select name="role"
                                                    style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;
                                                    cursor: not-allowed; opacity: 0.7;
                                                    background: {{ $user->role == 'admin' ? '#e3f2fd' : '#f1f8e9' }};" disabled>
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>👤 Пользователь</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Администратор</option>
                                            </select>
                                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                                                 cursor: not-allowed; background: transparent;">
                                            </div>
                                        </div>
                                    @else

                                        <form method="POST" action="{{ route('admin.users.update-role', $user) }}"
                                              style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <select name="role"
                                                    style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px;
                                                    cursor: pointer; transition: all 0.3s ease;
                                                    background: {{ $user->role == 'admin' ? '#e3f2fd' : '#f1f8e9' }};"
                                                    onchange="this.closest('form').submit()">
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>👤 Пользователь</option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Администратор</option>
                                            </select>
                                        </form>
                                    @endif

                                </td>
                                <td style="padding: 1rem;">
                                    <form method="POST" action="{{ route('admin.users.toggle-organizer', $user) }}"
                                          style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        @if($user->id == auth()->id() || $user->id == 1)
                                            <button type="submit"
                                                    style="padding: 0.5rem 1rem;
                                                           background: {{ $user->is_organizer ? '#4CAF50' : '#ff6b6b' }};
                                                           color: white; border: none; border-radius: 5px; cursor: not-allowed;
                                                           opacity: 0.7;">
                                                {{ $user->is_organizer ? 'Да' : 'Нет' }}
                                            </button>

                                        @else
                                            <button type="submit"
                                                    style="padding: 0.5rem 1rem;
                                                           background: {{ $user->is_organizer ? '#4CAF50' : '#ff6b6b' }};
                                                           color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                {{ $user->is_organizer ? 'Да' : 'Нет' }}
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td style="padding: 1rem; color: #666; font-size: 0.9rem;">
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td style="padding: 1rem;">
                                    @if($user->id == auth()->id() || $user->id == 1)
                                        <button type="button"
                                                style="padding: 0.5rem 1rem; background: #ff6b6b; color: white;
                                                border: none; border-radius: 5px; cursor: not-allowed;
                                                opacity: 0.7;">
                                            Удалить
                                        </button>

                                    @else
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}?')"
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    style="padding: 0.5rem 1rem; background: #ff6b6b; color: white;
                                                    border: none; border-radius: 5px; cursor: pointer;
                                                    transition: all 0.3s ease;">
                                                Удалить
                                            </button>
                                        </form>
                                    @endif

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
