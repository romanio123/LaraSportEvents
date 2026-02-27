@extends('layouts.app')

@section('content')
    <h1 style="margin-bottom: 2rem;">Все мероприятия</h1>

    <div style="background: white; padding: 2rem; border-radius: 10px; margin-bottom: 2rem;">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button style="padding: 0.5rem 1.5rem; border: 2px solid #667eea; background: white; border-radius: 20px; cursor: pointer;">
                Все
            </button>
            <button style="padding: 0.5rem 1.5rem; border: 2px solid #ddd; background: white; border-radius: 20px; cursor: pointer;">
                Марафоны
            </button>
            <button style="padding: 0.5rem 1.5rem; border: 2px solid #ddd; background: white; border-radius: 20px; cursor: pointer;">
                Велоспорт
            </button>
            <button style="padding: 0.5rem 1.5rem; border: 2px solid #ddd; background: white; border-radius: 20px; cursor: pointer;">
                Триатлон
            </button>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        @foreach($events as $event)
            <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="height: 200px; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                    {{ $event['category'] == 'Марафон' ? '🏃' : ($event['category'] == 'Велоспорт' ? '🚴' : ($event['category'] == 'Триатлон' ? '🏊' : '🏊‍♂️')) }}
                </div>

                <div style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 0.5rem;">{{ $event['title'] }}</h3>
                    <p style="color: #666; margin-bottom: 1rem;">{{ $event['description'] }}</p>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="color: #666;">
                            📅 {{ $event['date'] }}<br>
                            📍 {{ $event['city'] }}
                        </div>
                        <div style="font-size: 1.3rem; font-weight: bold; color: #ff6b6b;">
                            {{ $event['price'] }} ₽
                        </div>
                    </div>

                    <a href="/events/{{ $event['id'] }}" style="display: block; width: 100%; padding: 0.75rem; background: #667eea; color: white; text-align: center; border-radius: 5px; text-decoration: none;">
                        Подробнее
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
