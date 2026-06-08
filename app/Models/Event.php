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
        'category_id',
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
     * Связь с категорией
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с регистрациями
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Пользователи, зарегистрированные на мероприятие
     */
    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'registrations');
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