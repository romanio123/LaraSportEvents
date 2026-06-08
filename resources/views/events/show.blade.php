@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="event-detail-page">
    <div class="container">
        <div class="event-detail-grid">
            <!-- Левая колонка -->
            <div class="event-detail-left">
                <div class="event-image-main">
                    @if($event->image && Storage::disk('public')->exists($event->image))
                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                    @else
                        <div class="event-image-placeholder">
                            <i class="fas fa-calendar-alt fa-5x"></i>
                            <p>{{ $event->category }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="event-description-card">
                    <h2>Описание мероприятия</h2>
                    <p>{{ $event->description }}</p>
                </div>
                
                <div class="event-info-grid">
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Длительность</strong>
                            <span>3 часа</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tshirt"></i>
                        <div>
                            <strong>Экипировка</strong>
                            <span>Спортивная форма</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-parking"></i>
                        <div>
                            <strong>Парковка</strong>
                            <span>Бесплатно</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-water"></i>
                        <div>
                            <strong>Питьевая вода</strong>
                            <span>Есть на точке</span>
                        </div>
                    </div>
                </div>
                
                <div class="organizer-card">
                    <h3>Организатор</h3>
                    <div class="organizer-info">
                        <div class="organizer-avatar">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </div>
                        <div class="organizer-details">
                            <h4>{{ $event->user->name ?? 'SportEvents' }}</h4>
                            <p>Организатор спортивных мероприятий</p>
                            <div class="organizer-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>4.8 (124 отзыва)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Правая колонка -->
            <div class="event-detail-right">
                <div class="event-info-card">
                    <h1>{{ $event->title }}</h1>
                    
                    <div class="event-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('H:i') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->city }}, {{ $event->location }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <span>{{ $event->category }}</span>
                        </div>
                    </div>
                    
                    <div class="event-price-block">
                        @if($event->price > 0)
                            <div class="price-big">{{ number_format($event->price, 0, ',', ' ') }} ₽</div>
                            <div class="price-note">за участие</div>
                        @else
                            <div class="price-big free">Бесплатно</div>
                        @endif
                    </div>
                    
                    <div class="participants-progress">
                        <div class="progress-label">
                            <span>Участников</span>
                            <span>{{ $event->current_participants }} / {{ $event->max_participants }}</span>
                        </div>
                        <div class="progress-bar">
                            @php
                                $percent = $event->max_participants > 0 ? ($event->current_participants / $event->max_participants) * 100 : 0;
                            @endphp
                            <div class="progress-fill" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="slots-info">
                            @if($event->hasAvailableSlots())
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Свободно {{ $event->availableSlots() }} мест</span>
                            @else
                                <i class="fas fa-times-circle text-danger"></i>
                                <span>Мест нет</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($event->hasAvailableSlots())
    <button class="register-btn-large" onclick="openPaymentModal()">
        <i class="fas fa-credit-card me-2"></i>
        Зарегистрироваться
    </button>
    
    <div id="paymentModal" class="payment-modal">
        <div class="payment-modal-content">
            <div class="payment-modal-header">
                <h3>Оплата регистрации</h3>
                <span class="payment-modal-close" onclick="closePaymentModal()">&times;</span>
            </div>
            <div class="payment-modal-body">
                <div class="event-info">
                    <h4>{{ $event->title }}</h4>
                    <p><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->date)->format('d.m.Y H:i') }}</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $event->city }}, {{ $event->location }}</p>
                    <div class="payment-amount">
                        Сумма: <span class="amount">{{ number_format($event->price, 0, ',', ' ') }} ₽</span>
                    </div>
                </div>
                
                <form id="paymentForm" onsubmit="processPayment(event, {{ $event->id }})">
                    @csrf
                    <div class="form-group">
                        <label>Номер карты</label>
                        <input type="text" id="cardNumber" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Срок действия</label>
                            <input type="text" id="expiryDate" class="form-control" placeholder="MM/YY" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" id="cvv" class="form-control" placeholder="123" maxlength="3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Имя держателя</label>
                        <input type="text" id="cardName" class="form-control" placeholder="IVAN IVANOV">
                    </div>
                    <button type="submit" class="pay-btn">
                        <i class="fas fa-lock me-2"></i>
                        Оплатить {{ number_format($event->price, 0, ',', ' ') }} ₽
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <button class="register-btn-large disabled" disabled>
        <i class="fas fa-ban me-2"></i>
        Мест нет
    </button>
@endif
                    
                    <div class="security-note">
                        <i class="fas fa-lock"></i>
                        <span>Безопасная регистрация</span>
                    </div>
    

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openPaymentModal() {
    document.getElementById('paymentModal').style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

function processPayment(event, eventId) {
    event.preventDefault();
    
    const cardNumber = document.getElementById('cardNumber').value;
    const expiryDate = document.getElementById('expiryDate').value;
    const cvv = document.getElementById('cvv').value;
    const cardName = document.getElementById('cardName').value;
    
    if (!cardNumber || !expiryDate || !cvv || !cardName) {
        alert('Пожалуйста, заполните все поля');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("event.register", $event->id) }}';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Закрытие модального окна при клике вне его
window.onclick = function(event) {
    const modal = document.getElementById('paymentModal');
    if (event.target === modal) {
        closePaymentModal();
    }
}

// Форматирование полей
document.getElementById('cardNumber')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
    e.target.value = value.substring(0, 19);
});

document.getElementById('expiryDate')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value.substring(0, 5);
});

document.getElementById('cvv')?.addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
});
</script>
@endsection