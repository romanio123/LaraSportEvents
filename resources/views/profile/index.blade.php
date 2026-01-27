@extends('layouts.app')

@section('content')
    <h1 style="margin-bottom: 2rem;">Профиль пользователя</h1>

    <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom: 1rem;">Данные профиля</h2>
        <p><strong>Имя:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Роль:</strong> {{ $user->role == 'admin' ? 'Администратор' : 'Пользователь' }}</p>
        @if($user->is_organizer)
            <p><strong>Статус:</strong> Организатор</p>
        @endif
        <p><strong>Зарегистрирован:</strong> {{ $user->created_at->format('d.m.Y') }}</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Выйти</button>
        </form>
    </div>

@endsection
