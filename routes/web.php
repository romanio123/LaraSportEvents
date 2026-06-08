<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\SupportController; 

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

    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');                                                        
    // Аватар
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Управление профилем
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/update', [UserController::class, 'update'])->name('update');
        Route::delete('/delete', [UserController::class, 'destroy'])->name('destroy');
    });

    // Панель организатора (только для организаторов)
    Route::middleware('organizer')->prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');
        Route::get('/events', [OrganizerController::class, 'events'])->name('events.index');
        Route::get('/events/create', [OrganizerController::class, 'createEvent'])->name('events.create');
        Route::post('/events', [OrganizerController::class, 'storeEvent'])->name('events.store');
        Route::get('/events/{id}/edit', [OrganizerController::class, 'editEvent'])->name('events.edit');
        Route::put('/events/{id}', [OrganizerController::class, 'updateEvent'])->name('events.update');
        Route::delete('/events/{id}', [OrganizerController::class, 'deleteEvent'])->name('events.destroy');

        Route::get('/events/{event}/participants', [OrganizerController::class, 'participants'])->name('events.participants');
        Route::delete('/events/{event}/participants/{user}', [OrganizerController::class, 'removeParticipant'])->name('events.remove-participant');
    });

    Route::post('/event/{id}/register', [EventController::class, 'register'])->name('event.register');
    
    // ПОДДЕРЖКА (только для авторизованных)
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/message', [SupportController::class, 'message'])->name('support.message');

    // Админ-панель (только для администраторов)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/events', [AdminController::class, 'events'])->name('events');
        Route::get('/events/all', [AdminController::class, 'allEvents'])->name('events.all');
        Route::get('/helper', [AdminController::class, 'helpers'])->name('index');

        // Управление пользователями
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::put('/{user}/role', [UserController::class, 'updateRole'])->name('update-role');
            Route::put('/{user}/toggle-organizer', [UserController::class, 'toggleOrganizer'])->name('toggle-organizer');
            Route::delete('/{user}', [UserController::class, 'adminDestroy'])->name('destroy');
        });
        
        // Поддержка для админа
        Route::get('/support', [SupportController::class, 'adminIndex'])->name('support');
        Route::post('/support/{ticket}/close', [SupportController::class, 'close'])->name('support.close');
    });
});

// Статические страницы
Route::get('/tariffs', function () {
    return view('pages.tariffs');
})->name('tariffs');

Route::get('/documentation', function () {
    return view('pages.documentation');
})->name('documentation');

Route::get('/help', function () {
    return view('pages.help');
})->name('help');