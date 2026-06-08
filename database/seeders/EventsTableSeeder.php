<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Футбол', 'Баскетбол', 'Волейбол', 'Теннис', 'Плавание',
            'Йога', 'Бег', 'Велоспорт', 'Фитнес', 'Бокс',
            'Воркаут', 'Кроссфит', 'Танцы', 'Единоборства', 'Лыжи', 'Хоккей', 'Другое'
        ];
        
        $cities = [
            'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
            'Нижний Новгород', 'Челябинск', 'Самара', 'Омск', 'Ростов-на-Дону',
            'Уфа', 'Красноярск', 'Воронеж', 'Пермь', 'Волгоград', 'Краснодар',
            'Саратов', 'Тюмень', 'Тольятти', 'Ижевск'
        ];
        
        // Маппинг категорий на имена файлов
        $categoryImages = [
            'Футбол' => 'football.jpg',
            'Баскетбол' => 'basketball.jpg',
            'Волейбол' => 'volleyball.jpg',
            'Теннис' => 'tennis.jpg',
            'Плавание' => 'swimming.jpg',
            'Йога' => 'yoga.jpg',
            'Бег' => 'running.jpg',
            'Велоспорт' => 'bikesport.jpg',
            'Фитнес' => 'fitness.jpg',
            'Бокс' => 'box.jpg',
            'Воркаут' => 'workout.jpg',
            'Кроссфит' => 'crossfit.jpg',
            'Танцы' => 'dance.jpg',
            'Единоборства' => 'fight.jpg',
            'Лыжи' => 'skiing.jpg',
            'Хоккей' => 'hockey.jpg',
            'Другое' => 'more.jpg'
        ];
        
        // Проверка и вывод информации о папке
        $this->command->info('Проверка папки с изображениями...');
        $this->command->info('Путь: ' . storage_path('app/public/events'));
        
        if (!Storage::disk('public')->exists('events')) {
            $this->command->error('Папка events не существует! Создайте её: storage/app/public/events');
            Storage::disk('public')->makeDirectory('events');
            $this->command->info('Папка создана!');
        }
        
        // Выводим список файлов в папке
        $files = Storage::disk('public')->files('events');
        $this->command->info('Найдено файлов: ' . count($files));
        foreach ($files as $file) {
            $this->command->line(' - ' . $file);
        }
        
        $organizer = User::where('email', 'organizer@example.com')->first();
        if (!$organizer) {
            $organizer = User::create([
                'name' => 'Ivan Organizator',
                'email' => 'organizer@example.com',
                'password' => bcrypt('organizer123'),
                'role' => 'user',
                'is_organizer' => true,
            ]);
        }
        
        $admin = User::where('email', 'admin@sportevents.ru')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@sportevents.ru',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'is_organizer' => true,
            ]);
        }
        
        $titleTemplates = [
            'Чемпионат по {category}', 'Турнир "{category} лига"', 'Кубок города по {category}',
            'Открытая тренировка по {category}', 'Любительский турнир по {category}',
            'Мастер-класс по {category}', 'Соревнования по {category}', 'Фестиваль "{category}"'
        ];
        
        $descriptions = [
            'Отличная возможность провести время с пользой для здоровья.',
            'Ждём как профессионалов, так и любителей!',
            'Турнир с призовым фондом для победителей.',
            'Мастер-класс от опытных тренеров.',
            'Дружеская атмосфера и новые знакомства.'
        ];
        
        for ($i = 1; $i <= 100; $i++) {
            $category = $categories[array_rand($categories)];
            $city = $cities[array_rand($cities)];
            $template = $titleTemplates[array_rand($titleTemplates)];
            $title = str_replace('{category}', $category, $template);
            
            $daysFromNow = rand(1, 90);
            $date = Carbon::now()->addDays($daysFromNow);
            $hour = rand(9, 20);
            $minute = rand(0, 3) * 15;
            $date->setTime($hour, $minute);
            
            $maxParticipants = rand(10, 200);
            $price = rand(0, 3000);
            if ($price > 0) {
                $price = round($price / 100) * 100;
            }
            
            $description = $descriptions[array_rand($descriptions)];
            
            // Получаем имя файла изображения для категории
            $imageName = $categoryImages[$category] ?? 'more.jpg';
            $sourcePath = 'events/' . $imageName;
            $destPath = 'events/event_' . $i . '_' . time() . '.jpg';
            
            // Проверяем существует ли исходное изображение
            if (Storage::disk('public')->exists($sourcePath)) {
                // Копируем файл
                Storage::disk('public')->copy($sourcePath, $destPath);
                $imagePath = $destPath;
                $this->command->line("Мероприятие {$i}: изображение загружено - {$imageName}");
            } else {
                // Создаём SVG вместо изображения
                $this->command->warn("Мероприятие {$i}: файл {$imageName} не найден, создаём SVG");
                $svgContent = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="400" viewBox="0 0 800 400">
                    <rect width="800" height="400" fill="#667eea"/>
                    <text x="400" y="200" font-family="Arial" font-size="40" fill="white" text-anchor="middle">' . $category . '</text>
                    <text x="400" y="260" font-family="Arial" font-size="20" fill="white" text-anchor="middle">Спортивное мероприятие</text>
                </svg>';
                $destPath = 'events/event_' . $i . '_' . time() . '.svg';
                Storage::disk('public')->put($destPath, $svgContent);
                $imagePath = $destPath;
            }
            
            Event::create([
                'title' => $title,
                'description' => $description,
                'date' => $date,
                'location' => $city . ', ул. Спортивная, ' . rand(1, 50),
                'city' => $city,
                'price' => $price,
                'max_participants' => $maxParticipants,
                'current_participants' => rand(0, $maxParticipants),
                'category' => $category,
                'image' => $imagePath,
                'user_id' => rand(0, 1) ? $organizer->id : $admin->id,
            ]);
        }
        
        $this->command->info('100 мероприятий создано!');
    }
}