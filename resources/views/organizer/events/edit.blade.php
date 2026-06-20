@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
    <link href="{{ asset('css/edit-organizer.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="create-event-page">
    <div class="container">
        <!-- Заголовок -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>
                    Редактирование мероприятия
                </h1>
                <p class="page-subtitle">Измените информацию о спортивном событии</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-card">
                    <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" id="editEventForm">
                        @csrf
                        @method('PUT')

                        <!-- Основная информация -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <h4 class="section-title">Основная информация</h4>
                                    <p class="section-desc">Обновите информацию о мероприятии</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading"></i>
                                    Название мероприятия <span class="required">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $event->title) }}"
                                       required
                                       placeholder="Введите название мероприятия">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    Описание <span class="required">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="6"
                                          required
                                          placeholder="Опишите программу мероприятия...">{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-hint">
                                    <i class="fas fa-lightbulb"></i>
                                    Минимум 10 символов. Подробное описание привлекает больше участников
                                </small>
                            </div>
                        </div>

                        <!-- Дата и место -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <h4 class="section-title">Дата и место проведения</h4>
                                    <p class="section-desc">Укажите когда и где пройдёт событие</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date" class="form-label">
                                            <i class="fas fa-calendar-day"></i>
                                            Дата и время <span class="required">*</span>
                                        </label>
                                        <input type="datetime-local"
                                               class="form-control @error('date') is-invalid @enderror"
                                               id="date"
                                               name="date"
                                               value="{{ old('date', $event->date ? $event->date->format('Y-m-d\TH:i') : '') }}"
                                               required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city" class="form-label">
                                            <i class="fas fa-city"></i>
                                            Город <span class="required">*</span>
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
                                                <option value="{{ $city }}" {{ old('city', $event->city) == $city ? 'selected' : '' }}>
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
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="location" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Место проведения <span class="required">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location"
                                       name="location"
                                       value="{{ old('location', $event->location) }}"
                                       required
                                       placeholder="Адрес или название места">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-hint">
                                    <i class="fas fa-map-pin"></i>
                                    Например: ул. Спортивная, 15, стадион "Динамо"
                                </small>
                            </div>
                        </div>

                        <!-- Детали -->
                        <div class="form-section">
                            <div class="section-header">
                                <div class="section-icon">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                <div>
                                    <h4 class="section-title">Детали мероприятия</h4>
                                    <p class="section-desc">Настройте параметры участия</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category" class="form-label">
                                            <i class="fas fa-tag"></i>
                                            Категория <span class="required">*</span>
                                        </label>
                                        <select class="form-control @error('category') is-invalid @enderror" 
                                                id="category" 
                                                name="category" 
                                                required>
                                            <option value="">Выберите категорию</option>
                                            @foreach($categories as $key => $name)
                                                <option value="{{ $key }}" {{ old('category', $event->category) == $name ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_participants" class="form-label">
                                            <i class="fas fa-users"></i>
                                            Макс. участников <span class="required">*</span>
                                        </label>
                                        <input type="number"
                                               class="form-control @error('max_participants') is-invalid @enderror"
                                               id="max_participants"
                                               name="max_participants"
                                               value="{{ old('max_participants', $event->max_participants) }}"
                                               min="{{ $event->current_participants }}"
                                               max="1000"
                                               required>
                                        @error('max_participants')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">
                                            <i class="fas fa-info-circle"></i>
                                            Минимум: {{ $event->current_participants }} (уже зарегистрированных участников)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price" class="form-label">
                                            <i class="fas fa-ruble-sign"></i>
                                            Стоимость участия
                                        </label>
                                        <div class="price-input-wrapper">
                                            <span class="price-currency">₽</span>
                                            <input type="number"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   id="price"
                                                   name="price"
                                                   value="{{ old('price', $event->price) }}"
                                                   min="0"
                                                   step="10"
                                                   style="color: #10b981; font-weight: 600;">
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Оставьте 0 для бесплатного мероприятия</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">
                                            <i class="fas fa-image"></i>
                                            Изображение
                                        </label>
                                        @if($event->image && Storage::disk('public')->exists($event->image))
                                            <div class="current-image">
                                                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}">
                                                <span class="image-label">Текущее изображение</span>
                                            </div>
                                        @endif
                                        <div class="image-upload-area" onclick="document.getElementById('image').click()">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <p>Нажмите для загрузки нового изображения</p>
                                            <span>PNG, JPG до 2MB</span>
                                        </div>
                                        <input type="file"
                                               class="form-control @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image"
                                               accept="image/*"
                                               style="display: none;">
                                        <div id="imagePreview" class="image-preview" style="display: none;">
                                            <img src="" alt="Preview">
                                            <button type="button" onclick="clearImage()" class="remove-image">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Оставьте пустым, если не хотите менять изображение</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопки -->
                        <div class="form-actions">
                            <a href="{{ route('organizer.events.index') }}" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Отмена
                            </a>
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="fas fa-save me-2"></i>
                                Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-sidebar">
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class="fas fa-info-circle"></i>
                            <h4>Информация о мероприятии</h4>
                        </div>
                        <div class="stats-preview">
                            <div class="stat-item">
                                <span class="stat-label">Создано:</span>
                                <span class="stat-value">{{ $event->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Участников:</span>
                                <span class="stat-value">{{ $event->current_participants }} / {{ $event->max_participants }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Статус:</span>
                                <span class="stat-value">
                                    @if($event->hasAvailableSlots())
                                        <span style="color: #10b981;">Есть места</span>
                                    @else
                                        <span style="color: #ef4444;">Заполнено</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-card-header">
                            <i class="fas fa-lightbulb"></i>
                            <h4>Советы</h4>
                        </div>
                        <ul class="tips-list">
                            <li><i class="fas fa-check-circle"></i> Обновите информацию, если изменились дата или место</li>
                            <li><i class="fas fa-check-circle"></i> Проверьте лимит участников</li>
                            <li><i class="fas fa-check-circle"></i> Добавьте новое изображение для привлечения внимания</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

</style>

<script>
// Показ/скрытие поля "Другой город"
document.getElementById('city').addEventListener('change', function() {
    const otherCityInput = document.getElementById('otherCity');
    if (this.value === 'other') {
        otherCityInput.style.display = 'block';
        otherCityInput.required = true;
    } else {
        otherCityInput.style.display = 'none';
        otherCityInput.required = false;
    }
});

// Предпросмотр изображения
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            img.src = event.target.result;
            preview.style.display = 'block';
            document.querySelector('.image-upload-area').style.display = 'none';
            // Скрываем текущее изображение если есть
            const currentImage = document.querySelector('.current-image');
            if (currentImage) {
                currentImage.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
});

function clearImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.querySelector('.image-upload-area').style.display = 'block';
    const currentImage = document.querySelector('.current-image');
    if (currentImage) {
        currentImage.style.display = 'block';
    }
}
</script>
@endsection