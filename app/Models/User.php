<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_organizer',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_organizer' => 'boolean',
        ];
    }

    /**
     * Проверка, является ли пользователь администратором
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Проверка, является ли пользователь организатором
     */
    public function isOrganizer(): bool
    {
        return $this->is_organizer === true;
    }

    /**
     * Получить форматированное имя роли
     */
    public function getRoleNameAttribute(): string
    {
        return $this->role === 'admin' ? 'Администратор' : 'Пользователь';
    }

    /**
     * Связь с мероприятиями (как организатор)
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    /**
     * Связь с регистрациями
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Мероприятия, на которые зарегистрирован пользователь
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'registrations');
    }

    /**
     * Связь с обращениями в поддержку
     */
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * Связь с сообщениями поддержки
     */
    public function supportMessages()
    {
        return $this->hasMany(SupportMessage::class);
    }
}