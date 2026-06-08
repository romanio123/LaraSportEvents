<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
public function index(Request $request)
{
    $query = Event::query();
    
    // Фильтр по категории
    if ($request->has('category') && $request->category && $request->category !== 'all') {
        $categoryMap = [
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
        
        $categoryName = $categoryMap[$request->category] ?? $request->category;
        $query->where('category', $categoryName);
    }
    
    // Поиск
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('city', 'like', '%' . $search . '%');
        });
    }
    
    $events = $query->where('date', '>', now())
        ->orderBy('date', 'asc')
        ->paginate(9);
    
    $categories = [
        (object)['slug' => 'all', 'name' => 'Все', 'icon' => 'fa-th-large'],
        (object)['slug' => 'football', 'name' => 'Футбол', 'icon' => 'fa-futbol'],
        // ... остальные категории
    ];
    
    return view('events.index', compact('events', 'categories'));
}

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();
        
        $existing = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();
        
        if ($existing) {
            return redirect()->route('profile')->with('error', 'Вы уже зарегистрированы на это мероприятие');
        }
        
        // Проверка свободных мест
        if (!$event->hasAvailableSlots()) {
            return redirect()->route('profile')->with('error', 'Нет свободных мест');
        }
        
        Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'confirmed'
        ]);
        
        $event->increment('current_participants');
        
        return redirect()->route('profile')->with('success', 'Вы успешно зарегистрировались на мероприятие "' . $event->title . '"');
    }

    public function getFillPercentageAttribute(): float
    {
        if ($this->max_participants == 0) {
            return 0;
        }
        return ($this->current_participants / $this->max_participants) * 100;
    }
}