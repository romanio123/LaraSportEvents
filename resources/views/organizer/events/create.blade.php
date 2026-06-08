@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-4">
        <div class="create-event-page">
            <h1 style="font-size: 2rem; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0;">
                    Создание мероприятия
                </h1>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card form-card">

                            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" id="createEventForm">
                                @csrf
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

