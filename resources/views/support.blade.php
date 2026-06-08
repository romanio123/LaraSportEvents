@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="events-header mb-4">
            <h1 class="events-title">Поддержка</h1>
            <p class="events-subtitle">Мы всегда готовы помочь вам! Ответим на вопросы, решим проблемы и выслушаем предложения</p>
        </div>


        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2 style="margin-bottom: 1rem;">Свяжитесь с нами</h2>

            <form>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Имя</label>
                    <input type="text" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Email</label>
                    <input type="email" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Сообщение</label>
                    <textarea rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                </div>

                <button type="submit" style="padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 5px; font-size: 1.1rem; cursor: pointer;">
                    Отправить
                </button>
            </form>
        </div>
    </div>
@endsection
