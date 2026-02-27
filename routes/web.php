<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;

// Главная
Route::get('/', [HomeController::class, 'index'])->name('home');

// Мероприятия
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Авторизация/Регистрация
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Защищенные маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // Панель организатора (только для организаторов)
    Route::middleware('organizer')->prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');
        Route::get('/events', [OrganizerController::class, 'events'])->name('events.index');
        Route::get('/events/create', [OrganizerController::class, 'createEvent'])->name('events.create');
        Route::post('/events', [OrganizerController::class, 'storeEvent'])->name('events.store');
        Route::get('/events/{id}/edit', [OrganizerEventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{id}', [OrganizerEventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [OrganizerEventController::class, 'destroy'])->name('events.destroy');
    });

    // Админ-панель (только для администраторов)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/events', [AdminController::class, 'events'])->name('events');

        // Управление пользователями
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::put('/{user}/role', [UserController::class, 'updateRole'])->name('update-role');
            Route::put('/{user}/toggle-organizer', [UserController::class, 'toggleOrganizer'])->name('toggle-organizer');
            Route::delete('/{user}', [UserController::class, 'adminDestroy'])->name('destroy');
        });
    });
});

// Поддержка (доступна всем)
Route::get('/support', function () {
    return view('support');
})->name('support');
