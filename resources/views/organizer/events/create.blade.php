@extends('layouts.app')

@section('title', 'Создание мероприятия')

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="create-event-page">
            <!-- Хлебные крошки -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('organizer.dashboard') }}">Панель организатора</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('organizer.events.index') }}">Мои мероприятия</a></li>
                    <li class="breadcrumb-item active">Создание мероприятия</li>
                </ol>
            </nav>

            <div class="row justify-content-center">
                <!-- Центральная колонка - форма на всю ширину -->
                <div class="col-lg-10">
                    <div class="card form-card">
                        <div class="card-header">
                            <h2 class="mb-0">Создание нового мероприятия</h2>
                            <p class="text-muted mb-0">Заполните все необходимые поля</p>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <h5 class="alert-heading">Обнаружены ошибки:</h5>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" id="createEventForm">
                                @csrf

                                <!-- Основная информация -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Основная информация
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">
                                                Название мероприятия <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   id="title"
                                                   name="title"
                                                   value="{{ old('title') }}"
                                                   required
                                                   placeholder="Введите название мероприятия">
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">
                                                Описание <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      id="description"
                                                      name="description"
                                                      rows="5"
                                                      required
                                                      placeholder="Опишите ваше мероприятие">{{ old('description') }}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Минимум 10 символов. Подробно опишите программу мероприятия.</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Дата и место проведения -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Дата и место проведения
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="date" class="form-label">
                                                Дата и время <span class="text-danger">*</span>
                                            </label>
                                            <input type="datetime-local"
                                                   class="form-control @error('date') is-invalid @enderror"
                                                   id="date"
                                                   name="date"
                                                   value="{{ old('date') }}"
                                                   required>
                                            @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">
                                                Город <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control @error('city') is-invalid @enderror"
                                                    id="city"
                                                    name="city"
                                                    required>
                                                <option value="">Выберите город</option>
                                                @php
                                                    $defaultCities = [
                                                        'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
                                                        'Нижний Новгород', 'Челябинск', 'Самара', 'Омск', 'Ростов-на-Дону',
                                                        'Уфа', 'Красноярск', 'Воронеж', 'Пермь', 'Волгоград',
                                                        'Краснодар', 'Саратов', 'Тюмень', 'Тольятти', 'Ижевск'
                                                    ];
                                                    $cities = $cities ?? $defaultCities;
                                                @endphp

                                                @foreach($cities as $city)
                                                    <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                                                        {{ $city }}
                                                    </option>
                                                @endforeach
                                                <option value="other">Другой город</option>
                                            </select>
                                            @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <input type="text"
                                                   class="form-control mt-2 @error('other_city') is-invalid @enderror"
                                                   id="otherCity"
                                                   name="other_city"
                                                   value="{{ old('other_city') }}"
                                                   style="display: none;"
                                                   placeholder="Введите название города">
                                            @error('other_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="location" class="form-label">
                                                Место проведения <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('location') is-invalid @enderror"
                                                   id="location"
                                                   name="location"
                                                   value="{{ old('location') }}"
                                                   required
                                                   placeholder="Адрес или название места">
                                            @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Например: ул. Спортивная, 15, стадион "Динамо"</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Детали мероприятия -->
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <i class="fas fa-tag me-2"></i>
                                        Детали мероприятия
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="category" class="form-label">
                                                Категория <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control @error('category') is-invalid @enderror"
                                                    id="category"
                                                    name="category"
                                                    required>
                                                <option value="">Выберите категорию</option>
                                                @php
                                                    $defaultCategories = [
                                                        'football' => 'Футбол',
                                                        'basketball' => 'Баскетбол',
                                                        'volleyball' => 'Волейбол',
                                                        'tennis' => 'Теннис',
                                                        'swimming' => 'Плавание',
                                                        'yoga' => 'Йога',
                                                        'running' => 'Бег',
                                                        'cycling' => 'Велоспорт',
                                                        'fitness' => 'Фитнес',
                                                        'boxing' => 'Бокс',
                                                        'workout' => 'Воркаут',
                                                        'crossfit' => 'Кроссфит',
                                                        'dancing' => 'Танцы',
                                                        'martial_arts' => 'Единоборства',
                                                        'skiing' => 'Лыжи',
                                                        'hockey' => 'Хоккей',
                                                        'other' => 'Другое'
                                                    ];
                                                    $categories = $categories ?? $defaultCategories;
                                                @endphp

                                                @foreach($categories as $key => $name)
                                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="max_participants" class="form-label">
                                                Макс. участников <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                   class="form-control @error('max_participants') is-invalid @enderror"
                                                   id="max_participants"
                                                   name="max_participants"
                                                   value="{{ old('max_participants', 10) }}"
                                                   min="1"
                                                   max="1000"
                                                   required>
                                            @error('max_participants')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">От 1 до 1000 человек</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label">
                                                Стоимость участия (₽)
                                            </label>
                                            <input type="number"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   id="price"
                                                   name="price"
                                                   value="{{ old('price', 0) }}"
                                                   min="0"
                                                   step="0.01">
                                            @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Оставьте 0 для бесплатного мероприятия</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">
                                                Изображение мероприятия
                                            </label>
                                            <input type="file"
                                                   class="form-control @error('image') is-invalid @enderror"
                                                   id="image"
                                                   name="image"
                                                   accept="image/*">
                                            @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Рекомендуемый размер: 1200×600px, макс. 2MB</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Кнопки -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('organizer.events.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Отмена
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        Создать мероприятие
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .create-event-page {
        padding: 20px 0 40px;
    }

    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .form-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
        border-bottom: none;
    }

    .form-card .card-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #667eea;
        display: inline-block;
    }

    .form-label {
        font-weight: 500;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .breadcrumb {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-outline-secondary {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
    }

    @media (max-width: 768px) {
        .create-event-page {
            padding: 10px;
        }

        .form-card .card-header {
            padding: 1rem;
        }

        .form-card .card-body {
            padding: 1rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .btn-primary, .btn-outline-secondary {
            width: 100%;
            margin: 5px 0;
        }

        .d-flex {
            flex-direction: column-reverse;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .create-event-page {
        animation: fadeIn 0.5s ease;
    }
</style>
