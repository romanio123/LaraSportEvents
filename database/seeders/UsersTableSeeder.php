<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Функция транслитерации (русские буквы в латиницу)
        $translit = function($text) {
            $map = [
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e',
                'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
                'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
                'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
                'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E',
                'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
                'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
                'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
                'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
            ];
            return strtr($text, $map);
        };
        
        // Администратор
        User::updateOrCreate(
            ['email' => 'admin@sportevents.ru'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_organizer' => true,
            ]
        );

        // Организатор
        User::updateOrCreate(
            ['email' => 'organizer@sportevents.ru'],
            [
                'name' => 'Ivan Organizator',
                'password' => Hash::make('organizer123'),
                'role' => 'user',
                'is_organizer' => true,
            ]
        );

        $firstNames = [
            'Alex', 'Dmitry', 'Maxim', 'Artyom', 'Nikita', 'Mikhail', 'Daniel', 'Egor', 'Andrey', 'Timofey',
            'Matvey', 'Alexey', 'Roman', 'Sergey', 'Vladimir', 'Yaroslav', 'Ilya', 'Kirill', 'Gleb', 'Vyacheslav',
            'Evgeny', 'Fedor', 'Vadim', 'Oleg', 'Valery', 'Boris', 'Stanislav', 'Grigory', 'Semen', 'Peter',
            'Anna', 'Maria', 'Elena', 'Olga', 'Tatyana', 'Natalia', 'Irina', 'Svetlana', 'Ksenia', 'Yulia',
            'Anastasia', 'Daria', 'Victoria', 'Ekaterina', 'Alena', 'Polina', 'Valeria', 'Alina', 'Diana', 'Eugenia'
        ];
        
        $lastNames = [
            'Ivanov', 'Petrov', 'Sidorov', 'Smirnov', 'Kuznetsov', 'Popov', 'Vasiliev', 'Sokolov', 'Mikhailov', 'Novikov',
            'Fedorov', 'Morozov', 'Volkov', 'Alekseev', 'Lebedev', 'Semenov', 'Egorov', 'Pavlov', 'Kozlov', 'Stepanov',
            'Nikolaev', 'Orlov', 'Andreev', 'Makarov', 'Nikitin', 'Zakharov', 'Soloviev', 'Borisov', 'Kiselev', 'Timofeev'
        ];

        $domains = ['gmail.com', 'yandex.ru', 'mail.ru', 'inbox.ru', 'bk.ru', 'list.ru'];

        for ($i = 1; $i <= 100; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $domain = $domains[array_rand($domains)];
            
            $email = strtolower($firstName . '.' . $lastName . $i . '@' . $domain);
            
            $email = preg_replace('/\.\./', '.', $email);
            
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'is_organizer' => false,
                ]
            );
        }
    }
}