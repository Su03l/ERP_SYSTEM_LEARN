<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LeaveStatus;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => LeaveStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
