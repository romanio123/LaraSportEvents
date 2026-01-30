@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Мои мероприятия</h1>

            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-calendar-alt fa-4x text-muted"></i>
                    </div>

                    <h3 class="text-muted mb-3">У вас пока нет мероприятий</h3>
                    <a href="{{ route('organizer.events.create') }}" class="btn btn-primary btn-gradient px-4">
                        <i class="fas fa-plus me-2"></i> Создать мероприятие
                    </a>
                </div>
            </div>
@endsection
