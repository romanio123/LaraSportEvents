<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@sportevents.ru',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_organizer' => true,
            'email_verified_at' => now(),
        ]);

        // Создаем тестового организатора
        User::create([
            'name' => 'Иван Организатор',
            'email' => 'organizer@sportevents.ru',
            'password' => Hash::make('organizer123'),
            'role' => 'user',
            'is_organizer' => true,
            'email_verified_at' => now(),
        ]);

        // Создаем обычного пользователя
        User::create([
            'name' => 'Александр Участник',
            'email' => 'user@sportevents.ru',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_organizer' => false,
            'email_verified_at' => now(),
        ]);

        // Создаем еще несколько тестовых пользователей
        User::factory(7)->create();
    }
}
