<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LeaveStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\LeaveRequestObserver;

#[ObservedBy([LeaveRequestObserver::class])]
class LeaveRequest extends Model
{
    use HasFactory;

    //  
    protected $guarded = [];

    //  من اجل تحويل البيانات الى 
    protected $casts = [
        'status' => LeaveStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    //  من اجل جلب المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
