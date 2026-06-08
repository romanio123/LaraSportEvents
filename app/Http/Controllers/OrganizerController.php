<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->get();
        return view('organizer.index', compact('user', 'events'));
    }

    public function events(Request $request)
    {
        $user = Auth::user();
        $query = Event::where('user_id', $user->id);
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }
        
        $events = $query->orderBy('date', 'asc')->paginate(10);

        $events->appends(['search' => $request->search]);
        $eventsTotal = Event::where('user_id', $user->id)->count();
        
        return view('organizer.events.index', compact('events', 'eventsTotal'));
    }

    public function createEvent()
    {
        $categories = [
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

        $cities = [
            'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
            'Нижний Новгород', 'Челябинск', 'Самара', 'Омск', 'Ростов-на-Дону',
            'Уфа', 'Красноярск', 'Воронеж', 'Пермь', 'Волгоград', 'Краснодар',
            'Саратов', 'Тюмень', 'Тольятти', 'Ижевск', 'Барнаул', 'Иркутск',
            'Хабаровск', 'Владивосток', 'Сочи', 'Калининград'
        ];

        return view('organizer.events.create', compact('categories', 'cities'));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1|max:1000',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
            'other_city' => 'nullable|string|max:100|required_if:city,other',
        ]);

        if ($validated['city'] === 'other' && !empty($validated['other_city'])) {
            $validated['city'] = $validated['other_city'];
        }
        
        unset($validated['other_city']);
        
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
        
        $validated['category'] = $categoryMap[$validated['category']] ?? $validated['category'];
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        $eventData = array_merge($validated, [
            'user_id' => Auth::id(),
            'current_participants' => 0,
        ]);

        $event = Event::create($eventData);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Мероприятие "' . $event->title . '" успешно создано!');
    }

    public function editEvent($id)
    {
        $event = Event::where('user_id', Auth::id())->findOrFail($id);
        
        $categories = [
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
        
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::where('user_id', Auth::id())->findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:' . $event->current_participants,
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|max:2048',
        ]);
        
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
        
        $validated['category'] = $categoryMap[$validated['category']] ?? $validated['category'];
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }
        
        $event->update($validated);
        
        return redirect()->route('organizer.events.index')
            ->with('success', 'Мероприятие обновлено');
    }

    public function deleteEvent($id)
    {
        $event = Event::where('user_id', Auth::id())->findOrFail($id);
        $event->delete();
        
        return redirect()->route('organizer.events.index')
            ->with('success', 'Мероприятие удалено');
    }

    public function participants(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $participants = Registration::where('event_id', $event->id)
            ->with('user')
            ->latest()
            ->paginate(20);
        
        return view('organizer.events.participants', compact('event', 'participants'));
    }

    public function removeParticipant(Event $event, User $user)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $registration = Registration::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$registration) {
            return back()->with('error', 'Участник не найден');
        }
        
        $registration->delete();
        $event->decrement('current_participants');
        
        return back()->with('success', "Участник {$user->name} удален");
    }
}