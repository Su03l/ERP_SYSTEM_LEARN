<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceEvaluation extends Model
{
    protected $fillable = [
        'evaluator_id',
        'employee_id',
        'period',
        'punctuality',
        'quality',
        'teamwork',
        'communication',
        'productivity',
        'notes',
    ];

    protected $casts = [
        'overall_score' => 'decimal:2',
    ];

    // المشرف الذي أجرى التقييم
    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    // الموظف المُقيَّم
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // دالة لحساب التقدير اللفظي
    public function getGradeLabelAttribute(): string
    {
        $score = $this->overall_score;
        if ($score >= 4.5) return 'ممتاز';
        if ($score >= 3.5) return 'جيد جداً';
        if ($score >= 2.5) return 'جيد';
        if ($score >= 1.5) return 'مقبول';
        return 'ضعيف';
    }

    public function getGradeColorAttribute(): string
    {
        $score = $this->overall_score;
        if ($score >= 4.5) return 'green';
        if ($score >= 3.5) return 'blue';
        if ($score >= 2.5) return 'yellow';
        if ($score >= 1.5) return 'orange';
        return 'red';
    }
}
