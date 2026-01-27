@extends('layouts.app')

@section('content')
    <div>
        <h1 style="margin-bottom: 2rem;">Админ-панель</h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: #667eea; color: white; padding: 1.5rem; border-radius: 10px;">
                <h3 style="margin-bottom: 0.5rem;">Пользователи</h3>
                <div style="font-size: 2rem; font-weight: bold;">{{ $usersCount }}</div>
                <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.9rem;">
                    Админов: {{ $adminsCount }}, Организаторов: {{ $organizersCount }}
                </p>
            </div>

            <div style="background: #4CAF50; color: white; padding: 1.5rem; border-radius: 10px;">
                <h3 style="margin-bottom: 0.5rem;">Мероприятия</h3>
                <div style="font-size: 2rem; font-weight: bold;">{{ $eventsCount }}</div>
            </div>

        </div>

        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">Быстрые действия</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('admin.users.index') }}"
                   style="padding: 1.5rem; background: #f5f5f5; border-radius: 8px; text-decoration: none; color: #333; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
                    <div>Управление пользователями</div>
                </a>

                <a href="{{ route('admin.events') }}"
                   style="padding: 1.5rem; background: #f5f5f5; border-radius: 8px; text-decoration: none; color: #333; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📅</div>
                    <div>Все мероприятия</div>
                </a>
            </div>
        </div>


        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3>Последние пользователи</h3>
            </div>

            @if($recentUsers->isEmpty())
                <p style="color: #666; text-align: center; padding: 2rem;">Нет пользователей</p>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                        <tr style="border-bottom: 1px solid #eee;">
                            <th style="padding: 0.75rem; text-align: left;">Имя</th>
                            <th style="padding: 0.75rem; text-align: left;">Email</th>
                            <th style="padding: 0.75rem; text-align: left;">Роль</th>
                            <th style="padding: 0.75rem; text-align: left;">Дата регистрации</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recentUsers as $user)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 0.75rem;">{{ $user->name }}</td>
                                <td style="padding: 0.75rem;">{{ $user->email }}</td>
                                <td style="padding: 0.75rem;">
                                    <span style="padding: 0.25rem 0.5rem; background: {{ $user->role == 'admin' ? '#667eea' : '#4CAF50' }}; color: white; border-radius: 3px; font-size: 0.8rem;">
                                        {{ $user->role == 'admin' ? 'Админ' : 'Пользователь' }}
                                    </span>
                                    @if($user->is_organizer)
                                        <span style="padding: 0.25rem 0.5rem; background: #ff6b6b; color: white; border-radius: 3px; font-size: 0.8rem; margin-left: 0.25rem;">
                                            Организатор
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem; color: #666; font-size: 0.9rem;">
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
