<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'support_tickets';
    
    protected $fillable = [
        'user_id', 'subject', 'message', 'status', 'priority'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'ticket_id');
    }
    
    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }
}