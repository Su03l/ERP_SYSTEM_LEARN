<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقييم أداء - {{ $evaluation->employee->name }}</title>
    <style>
        body {
            font-family: 'sans-serif';
            direction: rtl;
            text-align: right;
            color: #333;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #172554;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #172554;
            margin: 0;
            font-size: 26px;
        }
        .header h3 {
            color: #64748b;
            margin: 10px 0 0 0;
            font-size: 16px;
            font-weight: normal;
        }
        .info-card {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .info-card p {
            margin: 8px 0;
            font-size: 14px;
        }
        .info-card strong {
            color: #1e293b;
            display: inline-block;
            width: 130px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px 15px;
            text-align: right;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #172554;
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
        }
        td {
            font-size: 14px;
            color: #475569;
        }
        .stars {
            color: #fbbf24;
            font-size: 18px;
            letter-spacing: 2px;
        }
        .stars-empty {
            color: #cbd5e1;
            font-size: 18px;
            letter-spacing: 2px;
        }
        .average-row td {
            font-weight: bold;
            background-color: #fef3c7;
            color: #92400e;
        }
        .notes-section {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 20px;
            border-radius: 6px;
            margin-top: 30px;
        }
        .notes-section h4 {
            margin: 0 0 10px 0;
            color: #1e293b;
            font-size: 15px;
        }
        .notes-section p {
            margin: 0;
            font-size: 14px;
            color: #475569;
            line-height: 1.8;
            white-space: pre-line;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        .meta-info {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 20px;
            border-radius: 6px;
            display: inline-block;
            margin-left: 10px;
        }
        .meta-box small {
            display: block;
            color: #94a3b8;
            font-size: 11px;
            margin-bottom: 3px;
        }
        .meta-box span {
            color: #1e293b;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
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
        </div>

        @php
            $criteria = [
                ['label' => 'الأداء العام', 'value' => $evaluation->overall_rating],
                ['label' => 'الالتزام', 'value' => $evaluation->commitment_rating],
                ['label' => 'العمل الجماعي', 'value' => $evaluation->teamwork_rating],
                ['label' => 'الإبداع والمبادرة', 'value' => $evaluation->creativity_rating],
                ['label' => 'التواصل', 'value' => $evaluation->communication_rating],
            ];
        @endphp

        <table>
            <thead>
                <tr>
                    <th>المعيار</th>
                    <th style="text-align: center;">التقييم</th>
                    <th style="text-align: center;">الدرجة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteria as $item)
                    <tr>
                        <td>{{ $item['label'] }}</td>
                        <td style="text-align: center;">
                            <span class="stars">{{ str_repeat('★', $item['value']) }}</span><span class="stars-empty">{{ str_repeat('★', 5 - $item['value']) }}</span>
                        </td>
                        <td style="text-align: center; font-weight: bold;">{{ $item['value'] }} / 5</td>
                    </tr>
                @endforeach
                <tr class="average-row">
                    <td>المتوسط العام</td>
                    <td style="text-align: center;">
                        <span class="stars">{{ str_repeat('★', round($evaluation->average_rating)) }}</span><span class="stars-empty">{{ str_repeat('★', 5 - round($evaluation->average_rating)) }}</span>
                    </td>
                    <td style="text-align: center; font-weight: bold; font-size: 16px;">{{ $evaluation->average_rating }} / 5</td>
                </tr>
            </tbody>
        </table>

        @if($evaluation->notes)
            <div class="notes-section">
                <h4>ملاحظات المشرف:</h4>
                <p>{{ $evaluation->notes }}</p>
            </div>
        @endif

        <div style="margin-top: 30px;">
            <div class="meta-box">
                <small>المقيِّم</small>
                <span>{{ $evaluation->evaluator->name }}</span>
            </div>
            <div class="meta-box">
                <small>تاريخ التقييم</small>
                <span>{{ $evaluation->created_at->format('Y-m-d') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>هذا المستند تم إصداره آلياً من النظام، ولا يحتاج إلى توقيع.</p>
            <p>تاريخ الإصدار: {{ now()->translatedFormat('l، j F Y') }}</p>
        </div>
    </div>
</body>
</html>
