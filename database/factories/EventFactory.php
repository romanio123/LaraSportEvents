<?php
// database/factories/EventFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Марафон', 'Велоспорт', 'Триатлон', 'Плавание', 'Бег', 'Йога', 'Фитнес'];
        $cities = ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань', 'Сочи'];

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'location' => $this->faker->address(),
            'city' => $this->faker->randomElement($cities),
            'price' => $this->faker->numberBetween(500, 5000),
            'max_participants' => $this->faker->numberBetween(50, 500),
            'current_participants' => $this->faker->numberBetween(0, 50),
            'category' => $this->faker->randomElement($categories),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Указать конкретную категорию
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }

    /**
     * Указать конкретный город
     */
    public function city(string $city): static
    {
        return $this->state(fn (array $attributes) => [
            'city' => $city,
        ]);
    }

    /**
     * Указать организатора
     */
    public function organizer(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Указать что мероприятие заполнено
     */
    public function full(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'current_participants' => $attributes['max_participants'],
            ];
        });
    }
}
