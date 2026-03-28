<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TicketStatus;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\TicketObserver;

#[ObservedBy([TicketObserver::class])]
class Ticket extends Model
{
    use HasFactory;

    // السماح بإضافة البيانات (Mass Assignment)
    protected $guarded = [];

    // تحويل حالة النص إلى Enum تلقائياً
    protected $casts = [
        'status' => TicketStatus::class,
    ];

    // علاقة التذكرة بصاحبها (الموظف)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
