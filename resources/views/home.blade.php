@extends('layouts.app')

@section('content')
    <h1 style="margin-bottom: 2rem;">Спортивные мероприятия</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        @foreach($events as $event)
            <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="height: 200px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    {{ $event['category'] == 'Марафон' ? '🏃' : ($event['category'] == 'Велоспорт' ? '🚴' : '🏊') }}
                </div>

                <div style="padding: 1.5rem;">
                    <div style="background: #ff6b6b; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; display: inline-block; margin-bottom: 1rem; font-size: 0.9rem;">
                        {{ $event['category'] }}
                    </div>

                    <h3 style="margin-bottom: 0.5rem;">{{ $event['title'] }}</h3>
                    <p style="color: #666; margin-bottom: 1rem;">{{ $event['description'] }}</p>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="color: #666;">
                            📅 {{ $event['date'] }}<br>
                            📍 {{ $event['city'] }}
                        </div>
                        <div style="font-size: 1.5rem; font-weight: bold; color: #ff6b6b;">
                            {{ $event['price'] }} ₽
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                            👥 {{ $event['current_participants'] }}/{{ $event['max_participants'] }} участников
                        </div>
                    </div>

                    <a href="/events/{{ $event['id'] }}" style="display: block; width: 100%; padding: 0.75rem; background: #667eea; color: white; text-align: center; border-radius: 5px; text-decoration: none;">
                        Подробнее
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 3rem; text-align: center;">
        <a href="/events" style="display: inline-block; padding: 1rem 2rem; background: #ff6b6b; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Все мероприятия →
        </a>
    </div>
@endsection
