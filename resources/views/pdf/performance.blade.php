<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقييم أداء - {{ $evaluation->employee->name }}</title>
    <style>
        body { font-family: 'sans-serif'; direction: rtl; text-align: right; color: #333; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 3px solid #172554; padding-bottom: 15px; }
        .header h1 { color: #172554; margin: 0; font-size: 24px; }
        .header h3 { color: #64748b; margin: 8px 0 0 0; font-size: 15px; font-weight: normal; }
        .info-card { background-color: #f1f5f9; border: 1px solid #cbd5e1; padding: 15px 20px; border-radius: 6px; margin-bottom: 25px; }
        .info-card p { margin: 6px 0; font-size: 13px; }
        .info-card strong { color: #1e293b; display: inline-block; width: 120px; }
        .section-title { background-color: #172554; color: #fff; padding: 8px 15px; font-size: 14px; font-weight: bold; margin: 0; }
        .section-meta { float: left; font-size: 12px; font-weight: normal; opacity: 0.8; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px 12px; text-align: right; border: 1px solid #e2e8f0; font-size: 13px; }
        th { background-color: #f1f5f9; color: #475569; font-weight: bold; font-size: 12px; }
        td { color: #475569; }
        .score-cell { text-align: center; font-weight: bold; }
        .result-box { background-color: #f8fafc; border: 2px solid #172554; border-radius: 8px; padding: 20px; margin-top: 25px; }
        .result-grid { display: table; width: 100%; }
        .result-item { display: table-cell; text-align: center; padding: 10px; width: 25%; }
        .result-label { font-size: 11px; color: #64748b; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .result-value { font-size: 22px; font-weight: bold; color: #172554; }
        .grade-excellent { color: #166534; }
        .grade-good { color: #1d4ed8; }
        .grade-ok { color: #a16207; }
        .grade-acceptable { color: #c2410c; }
        .grade-weak { color: #dc2626; }
        .notes-section { background-color: #f1f5f9; border: 1px solid #cbd5e1; padding: 15px 20px; border-radius: 6px; margin-top: 20px; }
        .notes-section h4 { margin: 0 0 8px 0; color: #1e293b; font-size: 14px; }
        .notes-section p { margin: 0; font-size: 13px; color: #475569; line-height: 1.8; white-space: pre-line; }
        .footer { margin-top: 40px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px; }
        .cat-score { float: left; font-size: 12px; background: #172554; color: #fff; padding: 4px 10px; border-radius: 4px; }
    </style>
</head>
<body>
    @php $structure = \App\Models\PerformanceEvaluation::criteriaStructure(); @endphp

    <div class="container">
        <div class="header">
            <h1>شركة النظام المتطور (ERP)</h1>
            <h3>تقرير تقييم الأداء الوظيفي</h3>
        </div>

        <div class="info-card">
            <p><strong>اسم الموظف:</strong> {{ $evaluation->employee->name }}</p>
            <p><strong>رقم الموظف:</strong> {{ $evaluation->employee->employee_number ?? '#'.$evaluation->employee->id }}</p>
            <p><strong>المسمى الوظيفي:</strong> {{ $evaluation->employee->job_title ?? 'غير محدد' }}</p>
            <p><strong>القسم:</strong> {{ $evaluation->employee->department ?? 'غير محدد' }}</p>
            <p><strong>فترة التقييم:</strong> {{ $evaluation->period_label }}</p>
            <p><strong>تاريخ التقييم:</strong> {{ $evaluation->created_at->format('Y-m-d') }}</p>
        </div>

        @foreach($structure as $catKey => $category)
            @php $score = $evaluation->getCategoryScore($catKey); @endphp
            <div class="section-title">
                {{ $category['label'] }}
                <span class="section-meta">الوزن: {{ $category['weight'] }} | المحقق: {{ $score['weighted'] }} / {{ $category['weight'] }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 55%;">مؤشر القياس</th>
                        <th style="width: 20%; text-align: center;">المستهدف</th>
                        <th style="width: 25%; text-align: center;">المحقق</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category['items'] as $itemKey => $itemLabel)
                        <tr>
                            <td>{{ $itemLabel }}</td>
                            <td class="score-cell">5</td>
                            <td class="score-cell" style="font-size: 14px;">{{ $evaluation->ratings[$itemKey] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        {{-- النتائج --}}
        <div class="result-box">
            <div class="result-grid">
                <div class="result-item">
                    <div class="result-label">النقاط الأساسية</div>
                    <div class="result-value">{{ $evaluation->total_score }} / 100</div>
                </div>
                <div class="result-item">
                    <div class="result-label">النسبة المئوية</div>
                    <div class="result-value">{{ $evaluation->percentage }}%</div>
                </div>
                <div class="result-item">
                    <div class="result-label">التقدير العام</div>
                    <div class="result-value {{ $evaluation->grade_color === 'green' ? 'grade-excellent' : ($evaluation->grade_color === 'blue' ? 'grade-good' : ($evaluation->grade_color === 'yellow' ? 'grade-ok' : ($evaluation->grade_color === 'orange' ? 'grade-acceptable' : 'grade-weak'))) }}">
                        {{ $evaluation->grade }}
                    </div>
                </div>
            </div>
        </div>

        @if($evaluation->notes)
            <div class="notes-section">
                <h4>ملاحظات المشرف:</h4>
                <p>{{ $evaluation->notes }}</p>
            </div>
        @endif

        <div style="margin-top: 25px; font-size: 13px;">
            <strong>المقيِّم:</strong> {{ $evaluation->evaluator->name }}
        </div>

        <div class="footer">
            <p>هذا المستند تم إصداره آلياً من النظام، ولا يحتاج إلى توقيع.</p>
            <p>تاريخ الإصدار: {{ now()->translatedFormat('l، j F Y') }}</p>
        </div>
    </div>
</body>
</html>
