<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceEvaluation extends Model
{
    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'overall_rating',
        'commitment_rating',
        'teamwork_rating',
        'creativity_rating',
        'communication_rating',
        'notes',
        'evaluation_period',
    ];

    /**
     * الموظف المُقيَّم
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * المُقيِّم (المشرف/الأدمن)
     */
    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    /**
     * حساب متوسط التقييم
     */
    public function getAverageRatingAttribute(): float
    {
        return round(($this->overall_rating + $this->commitment_rating + $this->teamwork_rating + $this->creativity_rating + $this->communication_rating) / 5, 1);
    }

    /**
     * تسمية فترة التقييم
     */
    public function getPeriodLabelAttribute(): string
    {
        return match ($this->evaluation_period) {
            'monthly' => 'شهري',
            'quarterly' => 'ربع سنوي',
            'yearly' => 'سنوي',
            default => $this->evaluation_period,
        };
    }
}
