@extends('layouts.app')

@section('title', 'Мои мероприятия')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Мои мероприятия</h1>
            <a href="{{ route('organizer.events.create') }}" class="btn btn-primary">Создать мероприятие</a>
        </div>

            <div class="alert alert-info">
                <p>У вас пока нет мероприятий.</p>
                <a href="{{ route('organizer.events.create') }}" class="btn btn-primary">Создать первое мероприятие</a>
            </div>
    </div>
@endsection
