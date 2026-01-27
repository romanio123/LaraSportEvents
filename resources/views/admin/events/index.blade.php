@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>Управление мероприятиями</h1>
            <div>
                <a href="{{ route('admin.index') }}"
                   style="padding: 0.75rem 1.5rem; background: #667eea; color: white; text-decoration: none; border-radius: 5px; margin-right: 1rem;">
                    ← Назад в панель
                </a>
            </div>
        </div>

        @if($events->isEmpty())
            <div style="background: white; padding: 3rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                <h3 style="margin-bottom: 1rem;">Мероприятий пока нет</h3>
                <p style="color: #666; margin-bottom: 1.5rem;">Создайте мероприятие через панель организатора</p>
            </div>
        @endif
    </div>
@endsection
