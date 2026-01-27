@extends('layouts.app')

@section('content')
    <div style="max-width: 400px; margin: 0 auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 2rem;">Вход в аккаунт</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Email</label>
                <input type="email" name="email" value="{{ ('email') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Пароль</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" style="width: 100%; padding: 1rem; background: #667eea; color: white; border: none; border-radius: 5px; font-size: 1.1rem; cursor: pointer; margin-bottom: 1rem;">
                Войти
            </button>

            <div style="text-align: center;">
                <a href="{{ route('register') }}" style="color: #667eea;">Нет аккаунта? Зарегистрируйтесь</a>
            </div>
        </form>
    </div>
@endsection
