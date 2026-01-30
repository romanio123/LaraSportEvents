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

            <div class="row">
                <!-- Левая колонка - форма -->
                <div class="col-lg-8">
                    <div class="card form-card">
                        <div class="card-header">
                            <h2 class="mb-0">Создание нового мероприятия</h2>
                            <p class="text-muted mb-0">Заполните все необходимые поля</p>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-section">
                                    <h4 class="section-title">Основная информация</h4>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="form-label">Название мероприятия *</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                   value="{{ old('title') }}" required placeholder="Введите название мероприятия">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Описание *</label>
                                            <textarea class="form-control" id="description" name="description"
                                                      rows="4" required placeholder="Опишите ваше мероприятие">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4 class="section-title">Дата и место проведения</h4>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="date" class="form-label">Дата и время *</label>
                                            <input type="datetime-local" class="form-control" id="date" name="date"
                                                   value="{{ old('date') }}" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label">Город *</label>
                                            <select class="form-control" id="city" name="city" required>
                                                <option value="">Выберите город</option>
                                                @php
                                                    $defaultCities = [
                                                        'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
                                                        'Нижний Новгород', 'Челябинск', 'Самара', 'Омск', 'Ростов-на-Дону',
                                                        'Уфа', 'Красноярск', 'Воронеж', 'Пермь', 'Волгоград'
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
                                            <input type="text" class="form-control mt-2" id="otherCity" name="other_city"
                                                   style="display: none;" placeholder="Введите название города">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="location" class="form-label">Место проведения *</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                                   value="{{ old('location') }}" required placeholder="Адрес или название места">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4 class="section-title">Детали мероприятия</h4>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="category" class="form-label">Категория *</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <option value="">Выберите категорию</option>
                                                @foreach($categories as $key => $name)
                                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="max_participants" class="form-label">Макс. участников *</label>
                                            <input type="number" class="form-control" id="max_participants" name="max_participants"
                                                   value="{{ old('max_participants', 10) }}" min="1" max="1000" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label">Стоимость участия (₽)</label>
                                            <input type="number" class="form-control" id="price" name="price"
                                                   value="{{ old('price', 0) }}" min="0" step="0.01">
                                            <small class="text-muted">Оставьте 0 для бесплатного мероприятия</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">Изображение мероприятия</label>
                                            <input type="file" class="form-control" id="image" name="image"
                                                   accept="image/*">
                                            <small class="text-muted">Рекомендуемый размер: 1200×600px</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus-circle me-2"></i> Создать мероприятие
                                    </button>
                                    <a href="{{ route('organizer.events.index') }}" class="btn btn-outline-secondary ms-2">
                                        Отмена
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обновление предпросмотра при вводе данных
            const titleInput = document.getElementById('title');
            const dateInput = document.getElementById('date');
            const locationInput = document.getElementById('location');
            const maxParticipantsInput = document.getElementById('max_participants');
            const priceInput = document.getElementById('price');
            const previewTitle = document.getElementById('preview-title');
            const previewDate = document.getElementById('preview-date');
            const previewLocation = document.getElementById('preview-location');
            const previewParticipants = document.getElementById('preview-participants');
            const previewPrice = document.getElementById('preview-price');
            const citySelect = document.getElementById('city');
            const otherCityInput = document.getElementById('otherCity');

            // Функция для форматирования даты
            function formatDateTime(dateTimeStr) {
                if (!dateTimeStr) return 'Дата не указана';
                const date = new Date(dateTimeStr);
                return date.toLocaleDateString('ru-RU', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            // Функция для форматирования цены
            function formatPrice(price) {
                price = parseFloat(price);
                if (price === 0 || isNaN(price)) return 'Бесплатно';
                return price.toLocaleString('ru-RU') + ' ₽';
            }

            // Обновление предпросмотра
            function updatePreview() {
                previewTitle.textContent = titleInput.value || 'Название мероприятия';

                if (dateInput.value) {
                    previewDate.textContent = formatDateTime(dateInput.value);
                }

                if (locationInput.value) {
                    previewLocation.textContent = locationInput.value;
                }

                if (maxParticipantsInput.value) {
                    previewParticipants.textContent = `Макс: ${maxParticipantsInput.value} участников`;
                }

                previewPrice.textContent = formatPrice(priceInput.value);
            }

            // Показать/скрыть поле для другого города
            citySelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherCityInput.style.display = 'block';
                    otherCityInput.required = true;
                } else {
                    otherCityInput.style.display = 'none';
                    otherCityInput.required = false;
                }
            });

            // Слушатели событий для обновления предпросмотра
            [titleInput, dateInput, locationInput, maxParticipantsInput, priceInput].forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('change', updatePreview);
            });

            // Инициализация предпросмотра
            updatePreview();

            // Валидация даты (нельзя выбрать прошедшую дату)
            const today = new Date().toISOString().slice(0, 16);
            dateInput.min = today;

            // Валидация формы
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let valid = true;

                // Проверка даты
                if (dateInput.value && new Date(dateInput.value) < new Date()) {
                    alert('Нельзя выбрать прошедшую дату');
                    valid = false;
                }

                // Проверка максимального количества участников
                if (parseInt(maxParticipantsInput.value) < 1) {
                    alert('Минимальное количество участников: 1');
                    valid = false;
                }

                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush

<style>

</style>
