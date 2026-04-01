<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceEvaluation extends Model
{
    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'ratings',
        'notes',
        'evaluation_period',
    ];

    protected $casts = [
        'ratings' => 'array',
    ];

    /**
     * هيكل معايير التقييم مع الأوزان
     */
    public static function criteriaStructure(): array
    {
        return [
            'quality' => [
                'label' => 'جودة العمل',
                'weight' => 20,
                'items' => [
                    'quality_appearance' => 'المظهر العام للموظف',
                    'quality_speed' => 'سرعة إنجاز العمل وإنجازه في الوقت المحدد',
                    'quality_errors' => 'الأخطاء التشغيلية',
                    'quality_property' => 'الحفاظ على ممتلكات الشركة',
                ],
            ],
            'discipline' => [
                'label' => 'الانضباط والالتزام',
                'weight' => 20,
                'items' => [
                    'discipline_attendance' => 'الحضور والانصراف (يتم خصم درجة لكل إفادة غياب)',
                    'discipline_policies' => 'الالتزام بسياسات وأخلاقيات الشركة',
                    'discipline_response' => 'الالتزام والتجاوب السريع مع القرارات والتوجيهات',
                    'discipline_reports' => 'الإفادات',
                ],
            ],
            'teamwork' => [
                'label' => 'العمل الجماعي',
                'weight' => 15,
                'items' => [
                    'teamwork_change' => 'تقبل الموظف التغيير في مجال العمل',
                    'teamwork_communication' => 'القدرة على الإصغاء والفهم ونقل الرسالة بوضوح',
                    'teamwork_initiative' => 'المبادرة ودعم الفريق',
                ],
            ],
            'leadership' => [
                'label' => 'القيادة والإشراف',
                'weight' => 45,
                'items' => [
                    'leadership_guidance' => 'التوجيه: هل يقوم بتوجيه مرؤوسيه نحو إنجاز المهام؟',
                    'leadership_ideas' => 'الأفكار والمقترحات لتحسين الأداء',
                    'leadership_planning' => 'التخطيط المسبق للأعمال والمهام',
                    'leadership_problem_solving' => 'المشاركة في حل المشكلات واتخاذ القرارات',
                    'leadership_decisiveness' => 'الحسم في اتخاذ القرارات',
                    'leadership_responsibility' => 'تحمل المسؤولية عن النتائج',
                    'leadership_understanding' => 'اتخاذ القرارات بناءً على الفهم والاتفاق',
                    'leadership_communication' => 'التواصل الفعال مع الإدارة والجهات ذات العلاقة',
                    'leadership_risks' => 'التنبيه للفرص والمخاطر',
                ],
            ],
        ];
    }

    /**
     * فترات التقييم المتاحة
     */
    public static function periodOptions(): array
    {
        return [
            'weekly' => 'أسبوعي',
            'monthly' => 'شهري',
            'quarterly' => '3 أشهر',
            'semi_annual' => '6 أشهر',
            'yearly' => 'سنوي',
        ];
    }

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
     * حساب نقاط فئة معينة
     */
    public function getCategoryScore(string $categoryKey): array
    {
        $structure = self::criteriaStructure();
        $category = $structure[$categoryKey] ?? null;

        // إذا لم يتم العثور على الفئة، أرجع أصفار
        if (!$category) return ['actual' => 0, 'max' => 0, 'weighted' => 0];

        $items = $category['items']; 
        $weight = $category['weight'];
        $maxRaw = count($items) * 5;
        $actual = 0;

        foreach (array_keys($items) as $key) {
            $actual += ($this->ratings[$key] ?? 0);
        }

        $weighted = $maxRaw > 0 ? round(($actual / $maxRaw) * $weight, 1) : 0;

        return [
            'actual' => $actual,
            'max' => $maxRaw,
            'weighted' => $weighted,
            'weight' => $weight,
        ];
    }

    /**
     * إجمالي النقاط من 100
     */
    public function getTotalScoreAttribute(): float
    {
        $total = 0;
        foreach (array_keys(self::criteriaStructure()) as $key) {
            $total += $this->getCategoryScore($key)['weighted'];
        }
        return round($total, 1);
    }

    /**
     * النسبة المئوية
     */
    public function getPercentageAttribute(): float
    {
        return $this->total_score;
    }

    /**
     * التقدير العام
     */
    public function getGradeAttribute(): string
    {
        $p = $this->percentage;
        if ($p >= 90) return 'ممتاز';
        if ($p >= 80) return 'جيد جداً';
        if ($p >= 70) return 'جيد';
        if ($p >= 60) return 'مقبول';
        return 'ضعيف';
    }

    /**
     * لون التقدير
     */
    public function getGradeColorAttribute(): string
    {
        $p = $this->percentage;
        if ($p >= 90) return 'green';
        if ($p >= 80) return 'blue';
        if ($p >= 70) return 'yellow';
        if ($p >= 60) return 'orange';
        return 'red';
    }

    /**
     * تسمية فترة التقييم
     */
    public function getPeriodLabelAttribute(): string
    {
        return self::periodOptions()[$this->evaluation_period] ?? $this->evaluation_period;
    }
}
