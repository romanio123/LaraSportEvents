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

    // ... остальные методы остаются без изменений
}
