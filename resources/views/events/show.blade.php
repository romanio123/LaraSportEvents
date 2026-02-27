@extends('layouts.app')

@section('content')
    <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 3rem 2rem; border-radius: 10px; margin-bottom: 2rem;">
        <h1 style="margin-bottom: 1rem;">{{ $event['title'] }}</h1>
        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <span>📅 {{ $event['date'] }}</span>
            <span>📍 {{ $event['location'] }}</span>
            <span>🏷️ {{ $event['price'] }} ₽</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div>
            <h2 style="margin-bottom: 1rem;">Описание</h2>
            <p style="margin-bottom: 2rem;">{{ $event['description'] }}</p>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 1rem;">Регистрация</h3>

            <div style="font-size: 2rem; font-weight: bold; color: #ff6b6b; margin-bottom: 1rem;">
                {{ $event['price'] }} ₽
                @if(isset($event['old_price']))
                    <div style="font-size: 1rem; color: #999; text-decoration: line-through;">
                        {{ $event['old_price'] }} ₽
                    </div>
                @endif
            </div>

            <div style="margin-bottom: 1rem;">
                <div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                    👥 {{ $event['current_participants'] }}/{{ $event['max_participants'] }} участников
                </div>
            </div>

            <button style="width: 100%; padding: 1rem; background: #ff6b6b; color: white; border: none; border-radius: 5px; font-size: 1.1rem; cursor: pointer; margin-bottom: 1rem;">
                Зарегистрироваться
            </button>

            <div style="text-align: center; color: #666; font-size: 0.9rem;">
                🔒 Безопасная оплата
            </div>
        </div>
    </div>

@endsection
