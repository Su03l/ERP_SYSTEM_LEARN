<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    protected $guarded = [];

    // علاقة التعليق بصاحبه
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة التعليق بالتذكرة
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
