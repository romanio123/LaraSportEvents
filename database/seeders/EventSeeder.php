<?php
// database/seeders/EventSeeder.php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Марафон', 'Велоспорт', 'Триатлон', 'Плавание', 'Бег', 'Йога', 'Фитнес'];
        $cities = ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань', 'Сочи'];

        // Получаем всех пользователей-организаторов
        $organizers = User::where('is_organizer', true)->get();

        if ($organizers->isEmpty()) {
            // Если нет организаторов, создадим хотя бы одного
            $organizer = User::factory()->organizer()->create([
                'name' => 'Организатор Событий',
                'email' => 'events@example.com',
            ]);
            $organizers = collect([$organizer]);
        }

        // Создаем 20 тестовых мероприятий
        for ($i = 1; $i <= 20; $i++) {
            $category = $categories[array_rand($categories)];
            $city = $cities[array_rand($cities)];
            $organizer = $organizers->random();

            Event::create([
                'title' => $this->generateEventTitle($category, $i),
                'description' => $this->generateEventDescription($category, $city),
                'date' => now()->addDays(rand(1, 365)),
                'location' => "Городской парк, $city",
                'city' => $city,
                'price' => rand(500, 5000),
                'max_participants' => rand(50, 500),
                'current_participants' => rand(0, 50),
                'category' => $category,
                'image' => null,
                'user_id' => $organizer->id,
            ]);
        }
    }

    private function generateEventTitle(string $category, int $index): string
    {
        $titles = [
            'Марафон' => ["Городской марафон", "Осенний марафон", "Благотворительный забег"],
            'Велоспорт' => ["Велосипедный тур", "Горная гонка", "Шоссейные соревнования"],
            'Триатлон' => ["Железный человек", "Спринт триатлон", "Зимний триатлон"],
            'Плавание' => ["Заплыв на открытой воде", "Бассейновые соревнования", "Марафонское плавание"],
            'Бег' => ["Кросс на 10км", "Спринтерские забеги", "Трейлраннинг"],
            'Йога' => ["Утренняя йога", "Йога в парке", "Медитативная практика"],
            'Фитнес' => ["Функциональный тренинг", "Кардио-марафон", "Силовая подготовка"],
        ];

        $categoryTitles = $titles[$category] ?? ["Спортивное мероприятие"];
        return $categoryTitles[array_rand($categoryTitles)] . " #$index";
    }

    private function generateEventDescription(string $category, string $city): string
    {
        $descriptions = [
            'Марафон' => "Забег на длинную дистанцию в городе $city. Подходит для профессиональных спортсменов и любителей.",
            'Велоспорт' => "Соревнования по велоспорту в живописных окрестностях $city. Трасса средней сложности.",
            'Триатлон' => "Комбинированное соревнование по плаванию, велогонке и бегу. Испытайте свои силы!",
            'Плавание' => "Соревнования по плаванию на открытой воде. Безопасность обеспечивается спасателями.",
            'Бег' => "Забег по городским улицам $city. Маршрут проходит через основные достопримечательности.",
            'Йога' => "Групповое занятие йогой на свежем воздухе. Подходит для всех уровней подготовки.",
            'Фитнес' => "Интенсивная тренировка под руководством профессионального тренера.",
        ];

        return $descriptions[$category] ?? "Спортивное мероприятие в городе $city.";
    }
}
