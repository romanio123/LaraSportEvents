@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@section('content')
<body class="auth-bg">
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Создать аккаунт</h2>
                <p>Присоединяйтесь к сообществу SportEvents</p>
            </div>
            <div class="auth-body">
                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                            name="name" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="auth-btn-2">
                        <i class="fas fa-user-plus me-2"></i> Зарегистрироваться
                    </button>

                    <div class="auth-footer">
                        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
                    </div>
                </form>
                
                <div class="sport-icons">
                    <i class="fas fa-futbol sport-icon"></i>
                    <i class="fas fa-basketball-ball sport-icon"></i>
                    <i class="fas fa-bicycle sport-icon"></i>
                    <i class="fas fa-swimmer sport-icon"></i>
                    <i class="fas fa-running sport-icon"></i>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection