<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'employee_number', 'email', 'password', 'role', 'status', 'job_title', 'department', 'phone', 'salary', 'national_id', 'join_date', 'bank_iban', 'address', 'emergency_contact', 'gender', 'birth_date', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'salary' => 'decimal:2',
            'join_date' => 'date',
            'birth_date' => 'date',
        ];
    }

    // علاقة الموظف بتذاكره
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // علاقة الموظف بطلبات الإجازة
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    // علاقة الموظف بتقييمات الأداء
    public function performanceEvaluations()
    {
        return $this->hasMany(PerformanceEvaluation::class, 'employee_id');
    }
}
