<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $table = 'support_messages';
    
    protected $fillable = [
        'ticket_id', 'user_id', 'message', 'is_admin'
    ];
    
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}