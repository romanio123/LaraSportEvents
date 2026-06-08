@extends('layouts.app')

@section('title', 'Поддержка')

@push('styles')
    <link href="{{ asset('css/support.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="support-page">
    <div class="container">
        <div class="support-header">
            <h1>Служба поддержки</h1>
            <p>Опишите вашу проблему, и мы свяжемся с вами в ближайшее время</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="support-form-card">
                    <h3><i class="fas fa-pen-alt me-2"></i>Новое обращение</h3>
                    
                    <form action="{{ route('support.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="subject"><i class="fas fa-tag"></i> Тема обращения</label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   placeholder="Кратко опишите проблему"
                                   value="{{ old('subject') }}"
                                   required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="message"><i class="fas fa-comment"></i> Сообщение</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      class="form-control @error('message') is-invalid @enderror" 
                                      placeholder="Опишите подробно вашу проблему..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            Отправить обращение
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="info-card">
                    <h3><i class="fas fa-info-circle me-2"></i>Как мы работаем</h3>
                    <ul class="info-list">
                        <li>
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Время ответа</strong>
                                <p>Обычно мы отвечаем в течение 24 часов</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-comments"></i>
                            <div>
                                <strong>Все обращения сохраняются</strong>
                                <p>Вы можете просмотреть историю в любое время</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Конфиденциальность</strong>
                                <p>Ваши данные надежно защищены</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Уведомления по email</strong>
                                <p>Мы пришлем уведомление на вашу почту</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                @if(isset($userTickets) && $userTickets->count() > 0)
                <div class="recent-tickets-card">
                    <h3><i class="fas fa-history me-2"></i>Мои обращения</h3>
                    <div class="tickets-list">
                        @foreach($userTickets->take(5) as $ticket)
                            <a href="{{ route('support.show', $ticket) }}" class="ticket-item">
                                <div class="ticket-info">
                                    <span class="ticket-subject">{{ $ticket->subject }}</span>
                                    <span class="ticket-date">{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="ticket-status status-{{ $ticket->status }}">
                                    @if($ticket->status == 'open')
                                        <i class="fas fa-circle-exclamation"></i> Открыто
                                    @elseif($ticket->status == 'in_progress')
                                        <i class="fas fa-spinner fa-spin"></i> В работе
                                    @else
                                        <i class="fas fa-check-circle"></i> Закрыто
                                    @endif
                                </span>
                            </a>
                        @endforeach
                    </div>
                    @if($userTickets->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('support.history') }}" class="btn-link">Все обращения →</a>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection