@extends('layouts.app')

@section('content')
    <div style="max-width: 400px; margin: 0 auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 2rem;">Регистрация</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Имя</label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Пароль</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" style="width: 100%; padding: 1rem; background: #ff6b6b; color: white; border: none; border-radius: 5px; font-size: 1.1rem; cursor: pointer; margin-bottom: 1rem;">
                Зарегистрироваться
            </button>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" style="color: #667eea;">Уже есть аккаунт? Войдите</a>
            </div>
        </form>
    </div>
@endsection
