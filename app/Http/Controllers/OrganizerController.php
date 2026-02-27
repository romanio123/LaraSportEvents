<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    /**
     * Панель организатора
     */
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->get();

        return view('organizer.index', compact('user', 'events'));
    }

    public function events()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id)->latest()->paginate(10);

        return view('organizer.events.index', compact('events'));
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
            'other' => 'Другое'
        ];

        $cities = [
            'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
            'Нижний Новгород', 'Челябинск', 'Самара', 'Омск', 'Ростов-на-Дону',
            'Уфа', 'Красноярск', 'Воронеж', 'Пермь', 'Волгоград'
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

}
