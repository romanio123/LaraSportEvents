@extends('layouts.app')

@section('title', 'Управление поддержкой')

@push('styles')
    <link href="{{ asset('css/admin-support.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="admin-support-page">
    <div class="container">
                   
        </div>
        <div class="d-flex justify-content-center align-items-center mb-4">
            <div class="events-header mb-4">
                <h1 class="events-title">Служба поддержки</h1>
                <p class="events-subtitle">Управление обращениями пользователей</p>
            </div>
        </div>
        
        <!-- Статистика - горизонтальные карточки -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['open'] ?? 0 }}</div>
                    <div class="stat-label">Открытых</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['in_progress'] ?? 0 }}</div>
                    <div class="stat-label">В работе</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['closed'] ?? 0 }}</div>
                    <div class="stat-label">Закрытых</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label">Всего обращений</div>
                </div>
            </div>
        </div>
        
        <!-- Таблица обращений -->
        <div class="table-container">
            <div class="table-header">
                <h3><i class="fas fa-list me-2"></i>Все обращения</h3>
            </div>
            
            @if($tickets->isEmpty())
                <p class="empty-state">Нет обращений</p>
            @else
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Пользователь</th>
                                <th>Тема</th>
                                <th>Статус</th>
                                <th>Дата</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>#{{ $ticket->id }}</td>
                                    <td>
                                        <div class="user-cell">
                                            <span>{{ $ticket->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ticket-subject">
                                            <strong>{{ Str::limit($ticket->subject, 35) }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $ticket->status }}">
                                            @if($ticket->status == 'open')
                                                <i class="fas fa-circle-exclamation"></i> Открыто
                                            @elseif($ticket->status == 'in_progress')
                                                <i class="fas fa-spinner fa-spin"></i> В работе
                                            @else
                                                <i class="fas fa-check-circle"></i> Закрыто
                                            @endif
                                        </span>
                                    </td>
                                    <td class="date-cell">{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="action-cell">
                                        <a href="{{ route('support.show', $ticket) }}" class="action-btn view" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($ticket->status !== 'closed')
                                            <form action="{{ route('admin.support.close', $ticket) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="action-btn close" title="Закрыть" onclick="return confirm('Закрыть обращение?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection