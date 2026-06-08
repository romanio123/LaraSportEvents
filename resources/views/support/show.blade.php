@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/support-show.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="support-ticket-page">
    <div class="container">
        <div class="ticket-container">
            <div class="ticket-header">
                <div>
                    <h1>Обращение #{{ $ticket->id }}</h1>
                    <p class="ticket-subject">{{ $ticket->subject }}</p>
                </div>
                <span class="ticket-status-badge status-{{ $ticket->status }}">
                    @if($ticket->status == 'open') 
                        <i class="fas fa-circle-exclamation"></i> Открыто
                    @elseif($ticket->status == 'in_progress') 
                        <i class="fas fa-spinner fa-spin"></i> В работе
                    @else 
                        <i class="fas fa-check-circle"></i> Закрыто
                    @endif
                </span>
            </div>
            
            <!-- Первое сообщение (создание обращения) -->
            <div class="message-first">
                <div class="message admin">
                    <div class="message-header">
                        <strong><i class="fas fa-user me-1"></i> {{ $ticket->user->name }}</strong>
                        <span class="message-time">{{ $ticket->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="message-body">
                        <p>{{ $ticket->message }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Диалог сообщений -->
            <div class="messages-container">
                @foreach($ticket->messages as $message)
                    <div class="message {{ $message->is_admin ? 'admin' : 'user' }}">
                        <div class="message-header">
                            <strong>
                                @if($message->is_admin)
                                    <i class="fas fa-headset me-1"></i> Служба поддержки
                                @else
                                    <i class="fas fa-user me-1"></i> {{ $message->user->name }}
                                @endif
                            </strong>
                            <span class="message-time">{{ $message->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="message-body">
                            <p>{{ $message->message }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Форма ответа (если обращение не закрыто) -->
            @if($ticket->status !== 'closed')
            <div class="reply-form">
                <form action="{{ route('support.message', $ticket) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="message">Ваш ответ</label>
                        <textarea id="message" name="message" rows="4" class="form-control" placeholder="Напишите сообщение..." required></textarea>
                    </div>
                    <button type="submit" class="btn-reply">
                        <i class="fas fa-paper-plane me-2"></i>
                        Отправить сообщение
                    </button>
                </form>
            </div>
            @else
                <div class="closed-info">
                    <i class="fas fa-lock"></i>
                    <p>Это обращение закрыто. Если у вас остались вопросы, создайте новое обращение.</p>
                </div>
            @endif
            
            <div class="nav-links">
                <a href="{{ route('support') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>
                    Назад к поддержке
                </a>
                
                @if(Auth::user()->role === 'admin' && $ticket->status !== 'closed')
                <form action="{{ route('admin.support.close', $ticket) }}" method="POST" style="display: inline;" onsubmit="return confirm('Закрыть обращение?')">
                    @csrf
                    <button type="submit" class="btn-close-ticket">
                        <i class="fas fa-check-circle me-2"></i>
                        Закрыть обращение
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection