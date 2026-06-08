@extends('layouts.app')

@section('title', 'Вход')

@push('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@section('content')
<body class="auth-bg">
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Добро пожаловать!</h2>
                <p>Войдите в свой аккаунт SportEvents</p>
            </div>
            <div class="auth-body">
                <form method="POST" action="{{ route('login') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autofocus>
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

                    <button type="submit" class="auth-btn-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Войти
                    </button>

                    <div class="auth-footer">
                        Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
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