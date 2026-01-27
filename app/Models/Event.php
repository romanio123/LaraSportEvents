<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'city',
        'price',
        'max_participants',
        'current_participants',
        'category',
        'image',
        'user_id',
    ];

    protected $casts = [
        'date' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Связь с пользователем (организатором)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope для поиска по категории
     */
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * Scope для поиска по городу
     */
    public function scopeByCity($query, $city)
    {
        if ($city) {
            return $query->where('city', 'like', "%{$city}%");
        }
        return $query;
    }

    /**
     * Проверка, есть ли свободные места
     */
    public function hasAvailableSlots(): bool
    {
        return $this->current_participants < $this->max_participants;
    }

    /**
     * Количество свободных мест
     */
    public function availableSlots(): int
    {
        return $this->max_participants - $this->current_participants;
    }

    /**
     * Процент заполненности
     */
    public function getFillPercentageAttribute(): float
    {
        if ($this->max_participants == 0) {
            return 0;
        }
        return ($this->current_participants / $this->max_participants) * 100;
    }
}
