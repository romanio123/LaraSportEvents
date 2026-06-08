@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/participant.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="participants-page">
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-users me-3"></i>
                    Участники мероприятия
                </h1>
                <p class="page-subtitle">{{ $event->title }} - {{ $event->date->format('d.m.Y H:i') }}</p>
            </div>
            <a href="{{ route('organizer.events.index') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>
                Назад к мероприятиям
            </a>
        </div>

        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $participants->total() }}</div>
                    <div class="stat-label">Всего участников</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $event->max_participants }}</div>
                    <div class="stat-label">Максимум мест</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chair"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $event->max_participants - $participants->total() }}</div>
                    <div class="stat-label">Свободно мест</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ \Carbon\Carbon::parse($event->date)->diffForHumans() }}</div>
                    <div class="stat-label">Дата мероприятия</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        <div class="table-container">
            <div class="table-header">
                <h3><i class="fas fa-list me-2"></i>Список участников</h3>
                <div class="table-info">
                    <i class="fas fa-info-circle"></i>
                    Всего: {{ $participants->total() }} участников
                </div>
            </div>

            @if($participants->isNotEmpty())
                <div class="table-responsive">
                    <table class="participants-table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Участник</th>
                                <th>Email</th>
                                <th>Дата регистрации</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $index => $participant)
                                <tr>
                                    <td class="participant-number">{{ $participants->firstItem() + $index }}</td>
                                    <td class="participant-name">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($participant->user->name, 0, 1)) }}
                                        </div>
                                        <strong>{{ $participant->user->name }}</strong>
                                    </td>
                                    <td class="participant-email">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ $participant->user->email }}
                                    </td>
                                    <td class="participant-date">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $participant->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="participant-status">
                                        <span class="status-badge confirmed">
                                            <i class="fas fa-check-circle"></i> Подтвержден
                                        </span>
                                    </td>
                                    <td class="participant-actions">
                                        <form action="{{ route('organizer.events.remove-participant', [$event, $participant->user]) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Удалить участника {{ $participant->user->name }} из мероприятия?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Удалить участника">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Пагинация -->
                @if ($participants->hasPages())
                    <div class="custom-pagination">
                        @if ($participants->onFirstPage())
                            <span class="disabled"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $participants->previousPageUrl() }}" class="page-nav">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        @foreach ($participants->getUrlRange(1, $participants->lastPage()) as $page => $url)
                            @if ($page == $participants->currentPage())
                                <span class="active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($participants->hasMorePages())
                            <a href="{{ $participants->nextPageUrl() }}" class="page-nav">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="disabled"><i class="fas fa-chevron-right"></i></span>
                        @endif
                    </div>
                    
                    <div class="pagination-info">
                        Показано с {{ $participants->firstItem() }} по {{ $participants->lastItem() }} 
                        из {{ $participants->total() }} участников
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h3>Нет зарегистрированных участников</h3>
                    <p>На это мероприятие пока никто не записался</p>
                    <a href="{{ route('organizer.events.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left me-2"></i>
                        Вернуться к мероприятиям
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection