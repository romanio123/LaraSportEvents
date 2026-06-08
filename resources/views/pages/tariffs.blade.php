@extends('layouts.app')

@section('content')
<div class="static-page">
    <div class="container mt-4">
        <div class="events-header mb-4">
            <div class="mb-4">
                <h1 class="events-title">Тарифы</h1>
            </div>
            <div class="tariffs-grid">
                <div class="tariff-card">
                    <h3>Базовый</h3>
                    <div class="price">Бесплатно</div>
                    <ul>
                        <li>До 5 мероприятий в месяц</li>
                        <li>До 50 участников</li>
                        <li>Базовая статистика</li>
                        <li>Поддержка по email</li>
                    </ul>
                    <button class="btn-primary" disabled>Текущий тариф</button>
                </div>
                <div class="tariff-card popular">
                    <div class="popular-badge">Популярный</div>
                    <h3>Профессиональный</h3>
                    <div class="price">2 990 ₽<span>/мес</span></div>
                    <ul>
                        <li>Неограниченное количество мероприятий</li>
                        <li>До 500 участников</li>
                        <li>Расширенная статистика</li>
                        <li>Приоритетная поддержка 24/7</li>
                        <li>API доступ</li>
                    </ul>
                    <button class="btn-primary">Выбрать тариф</button>
                </div>
                <div class="tariff-card">
                    <h3>Корпоративный</h3>
                    <div class="price">По запросу</div>
                    <ul>
                        <li>Индивидуальные условия</li>
                        <li>Неограниченные лимиты</li>
                        <li>Выделенный менеджер</li>
                        <li>Интеграция с CRM</li>
                    </ul>
                    <button class="btn-primary">Связаться</button>
                </div>
            </div>
    </div>
</div>
<style>
.tariffs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 2rem; }
.tariff-card { background: white; border-radius: 20px; padding: 2rem; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; }
.tariff-card.popular { transform: scale(1.02); border: 2px solid #667eea; }
.popular-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 4px 16px; border-radius: 20px; font-size: 0.8rem; }
.tariff-card h3 { font-size: 1.3rem; margin-bottom: 1rem; }
.tariff-card .price { font-size: 2rem; font-weight: 700; color: #667eea; margin-bottom: 1.5rem; }
.tariff-card .price span { font-size: 0.9rem; font-weight: normal; color: #718096; }
.tariff-card ul { list-style: none; padding: 0; margin-bottom: 2rem; }
.tariff-card li { padding: 0.5rem 0; color: #4a5568; border-bottom: 1px solid #e2e8f0; }
.tariff-card li:before { content: "✓"; color: #10b981; margin-right: 8px; }
@media (max-width: 768px) { .tariffs-grid { grid-template-columns: 1fr; } }
</style>
@endsection