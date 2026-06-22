<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;

class RegistrationsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')
            ->where('is_organizer', false)
            ->pluck('id'); // Только ID, а не все модели
        
        $events = Event::all();
        
        if ($events->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Нет мероприятий или пользователей');
            return;
        }
        
        $registrationsData = [];
        $updateData = [];
        
        foreach ($events as $event) {
            // Выбираем случайное количество участников
            $targetCount = rand(
                round($event->max_participants * 0.3),
                round($event->max_participants * 0.8)
            );
            $targetCount = min($targetCount, $users->count());
            
            // Берём случайных пользователей
            $selectedUsers = $users->random($targetCount);
            
            $registeredCount = 0;
            foreach ($selectedUsers as $userId) {
                // Добавляем данные для массовой вставки
                $registrationsData[] = [
                    'user_id' => $userId,
                    'event_id' => $event->id,
                    'status' => 'confirmed',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ];
                $registeredCount++;
            }
            
            // Сохраняем для обновления мероприятий
            $updateData[$event->id] = $registeredCount;
        }
        
        // Массовая вставка регистраций (ОДИН запрос!)
        if (!empty($registrationsData)) {
            Registration::insert($registrationsData);
        }
        
        // Массовое обновление мероприятий
        foreach ($updateData as $eventId => $count) {
            Event::where('id', $eventId)->update(['current_participants' => $count]);
        }
        
        $this->command->info('Создано ' . count($registrationsData) . ' регистраций');
    }
}