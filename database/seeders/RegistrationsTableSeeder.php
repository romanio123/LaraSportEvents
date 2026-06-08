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
            ->get();
        
        $events = Event::all();
        
        $registrationsCount = 0;
        
        foreach ($events as $event) {
            $targetParticipants = rand(
                round($event->max_participants * 0.3),
                round($event->max_participants * 0.8)
            );
            
            $targetParticipants = min($targetParticipants, $users->count());
            
            $selectedUsers = $users->random($targetParticipants);
            
            $registeredCount = 0;
            foreach ($selectedUsers as $user) {
                $exists = Registration::where('user_id', $user->id)
                    ->where('event_id', $event->id)
                    ->exists();
                
                if (!$exists) {
                    Registration::create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                        'status' => 'confirmed',
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now(),
                    ]);
                    $registeredCount++;
                    $registrationsCount++;
                }
            }
            
            $event->update([
                'current_participants' => $registeredCount
            ]);
        }
    }
}