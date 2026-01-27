<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_organizer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
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
     * События модели
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'user';
            }
        });
    }

    /**
     * Scope для администраторов
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope для организаторов
     */
    public function scopeOrganizers($query)
    {
        return $query->where('is_organizer', true);
    }

    /**
     * Scope для обычных пользователей
     */
    public function scopeRegular($query)
    {
        return $query->where('role', 'user')->where('is_organizer', false);
    }
}
