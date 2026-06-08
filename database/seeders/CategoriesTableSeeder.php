<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Футбол',
                'slug' => 'football',
                'description' => 'Футбольные матчи, турниры и тренировки',
                'icon' => 'fa-futbol',
                'color' => '#4CAF50',
                'sort_order' => 1,
            ],
            [
                'name' => 'Баскетбол',
                'slug' => 'basketball',
                'description' => 'Баскетбольные игры и соревнования',
                'icon' => 'fa-basketball-ball',
                'color' => '#FF9800',
                'sort_order' => 2,
            ],
            [
                'name' => 'Волейбол',
                'slug' => 'volleyball',
                'description' => 'Волейбольные матчи и турниры',
                'icon' => 'fa-volleyball-ball',
                'color' => '#2196F3',
                'sort_order' => 3,
            ],
            [
                'name' => 'Теннис',
                'slug' => 'tennis',
                'description' => 'Теннисные турниры и тренировки',
                'icon' => 'fa-table-tennis',
                'color' => '#9C27B0',
                'sort_order' => 4,
            ],
            [
                'name' => 'Плавание',
                'slug' => 'swimming',
                'description' => 'Соревнования по плаванию',
                'icon' => 'fa-swimmer',
                'color' => '#00BCD4',
                'sort_order' => 5,
            ],
            [
                'name' => 'Бег',
                'slug' => 'running',
                'description' => 'Забеги, марафоны и кроссы',
                'icon' => 'fa-running',
                'color' => '#E91E63',
                'sort_order' => 6,
            ],
            [
                'name' => 'Велоспорт',
                'slug' => 'cycling',
                'description' => 'Велосипедные гонки и прогулки',
                'icon' => 'fa-bicycle',
                'color' => '#FF5722',
                'sort_order' => 7,
            ],
            [
                'name' => 'Йога',
                'slug' => 'yoga',
                'description' => 'Занятия йогой и медитация',
                'icon' => 'fa-praying-hands',
                'color' => '#8BC34A',
                'sort_order' => 8,
            ],
            [
                'name' => 'Фитнес',
                'slug' => 'fitness',
                'description' => 'Фитнес тренировки и занятия',
                'icon' => 'fa-heartbeat',
                'color' => '#F44336',
                'sort_order' => 9,
            ],
            [
                'name' => 'Бокс',
                'slug' => 'boxing',
                'description' => 'Боксерские поединки и тренировки',
                'icon' => 'fa-fist-raised',
                'color' => '#795548',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}