@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/admin-support.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="admin-support-page">
    <div class="container">
        <div class="admin-support-header">
            <h1><i class="fas fa-headset me-3"></i>Служба поддержки</h1>
            <p>Управление обращениями пользователей</p>
        </div>
        
        <div class="support-stats-grid">
            <div class="support-stat-card">
                <div class="support-stat-icon open">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div class="support-stat-info">
                    <div class="support-stat-number">{{ $stats['open'] ?? 0 }}</div>
                    <div class="support-stat-label">Открытых</div>
                </div>
            </div>
            <div class="support-stat-card">
                <div class="support-stat-icon progress">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="support-stat-info">
                    <div class="support-stat-number">{{ $stats['in_progress'] ?? 0 }}</div>
                    <div class="support-stat-label">В работе</div>
                </div>
            </div>
            <div class="support-stat-card">
                <div class="support-stat-icon closed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="support-stat-info">
                    <div class="support-stat-number">{{ $stats['closed'] ?? 0 }}</div>
                    <div class="support-stat-label">Закрытых</div>
                </div>
            </div>
            <div class="support-stat-card">
                <div class="support-stat-icon total">
                    <i class="fas fa-users"></i>
                </div>
                <div class="support-stat-info">
                    <div class="support-stat-number">{{ $stats['total'] ?? 0 }}</div>
                    <div class="support-stat-label">Всего обращений</div>
                </div>
            </div>
        </div>
        
        <div class="support-table-container">
            <div class="support-table-header">
                <h2>
                    <i class="fas fa-list"></i>
                    Все обращения
                </h2>
            </div>
            
            <div class="table-responsive">
                <table class="support-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Тема</th>
                            <th>Статус</th>
                            <th>Приоритет</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>
                                    <span class="fw-semibold">#{{ $ticket->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-initial" style="width: 32px; height: 32px; background: rgba(102, 126, 234, 0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #667eea;">
                                            {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                        </div>
                                        {{ $ticket->user->name }}
                                    </div>
                                </td>
                                <td>
                                    <div style="max-width: 250px;">
                                        <strong>{{ Str::limit($ticket->subject, 35) }}</strong>
                                        <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 2px;">
                                            {{ Str::limit($ticket->message, 50) }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="support-status-badge {{ $ticket->status }}">
                                        @if($ticket->status == 'open')
                                            <i class="fas fa-circle-exclamation"></i> Открыто
                                        @elseif($ticket->status == 'in_progress')
                                            <i class="fas fa-spinner fa-spin"></i> В работе
                                        @else
                                            <i class="fas fa-check-circle"></i> Закрыто
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="support-priority-badge {{ $ticket->priority ?? 'medium' }}">
                                        <i class="fas fa-flag"></i>
                                        {{ ucfirst($ticket->priority ?? 'Средний') }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        {{ $ticket->created_at->format('d.m.Y H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="support-action-buttons">
                                        <a href="{{ route('support.show', $ticket) }}" class="support-action-btn view" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($ticket->status !== 'closed')
                                            <form action="{{ route('admin.support.close', $ticket) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="support-action-btn close" title="Закрыть" onclick="return confirm('Закрыть обращение?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="support-empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Нет обращений в поддержку</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection