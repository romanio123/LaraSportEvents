<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Показывает мероприятия текущего организатора
     */
    public function index()
    {
        $events = Event::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('organizer.events.index', compact('events'));
    }

    /**
     * Показывает форму создания мероприятия
     */
    public function create()
    {
        return view('organizer.events.create');
    }

    /**
     * Сохраняет новое мероприятие
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'city' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'category' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['current_participants'] = 0;

        Event::create($validated);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Мероприятие успешно создано!');
    }

    /**
     * Показывает форму редактирования
     */
    public function edit($id)
    {
        $event = Event::where('user_id', auth()->id())->findOrFail($id);
        return view('organizer.events.edit', compact('event'));
    }

    /**
     * Обновляет мероприятие
     */
    public function update(Request $request, $id)
    {
        $event = Event::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'city' => 'required|string',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'category' => 'required|string',
        ]);

        $event->update($validated);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Мероприятие успешно обновлено!');
    }

    /**
     * Удаляет мероприятие
     */
    public function destroy($id)
    {
        $event = Event::where('user_id', auth()->id())->findOrFail($id);
        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Мероприятие успешно удалено!');
    }
}
