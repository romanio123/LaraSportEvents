<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizerController;

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

// Защищенные маршруты
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Профиль
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    });

    // Панель организатора
    Route::middleware('organizer')->prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');
        Route::get('/events', [OrganizerController::class, 'events'])->name('events.index');
    });

    // Админ-панель
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

// Поддержка
Route::get('/support', function () {
    return view('support');
})->name('support');
