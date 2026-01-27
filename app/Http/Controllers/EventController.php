<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');

        $events = Event::with('user')
            ->where('date', '>', now())
            ->when($category, function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->orderBy('date')
            ->paginate(9);

        $categories = Event::distinct()->pluck('category');

        return view('events.index', [
            'events' => $events,
            'categories' => $categories,
            'selectedCategory' => $category
        ]);
    }

    public function show($id)
    {
        $event = Event::with('user')->findOrFail($id);

        // Добавляем features для совместимости со старым кодом
        $event->features = $this->getFeaturesByCategory($event->category);

        return view('events.show', ['event' => $event]);
    }

    private function getFeaturesByCategory($category): array
    {
        $featuresMap = [
            'Марафон' => ['Медаль финишера', 'Электронный чип', 'Фотофиниш', 'Питание'],
            'Велоспорт' => ['Техподдержка', 'Пункты питания', 'Страховка', 'Карта маршрута'],
            'Триатлон' => ['Аренда оборудования', 'Тренерский инструктаж', 'Сертификат', 'Раздевалка'],
            'Плавание' => ['Спасатели', 'Раздевалка', 'Душ', 'Питьевая вода'],
            'Бег' => ['Номер участника', 'Временные чипы', 'Медицинская помощь', 'Вода на дистанции'],
        ];

        return $featuresMap[$category] ?? ['Сертификат участника', 'Фотосессия', 'Сувениры'];
    }
}
