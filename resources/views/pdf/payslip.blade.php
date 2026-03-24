<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>مسير راتب - {{ $employee->name }}</title>
    <style>
        body {
            font-family: 'sans-serif';
            direction: rtl;
            text-align: right;
            color: #333;
            background-color: #f8fafc; /* brand-50 */
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
            border-bottom: 3px solid #172554; /* brand-950 */
            padding-bottom: 20px;
        }
        .header h1 {
            color: #172554; /* brand-950 */
            margin: 0;
            font-size: 26px;
        }
        .header h3 {
            color: #64748b; /* slate-500 */
            margin: 10px 0 0 0;
            font-size: 16px;
            font-weight: normal;
        }
        .info-card {
            background-color: #f1f5f9; /* slate-100 */
            border: 1px solid #cbd5e1; /* slate-300 */
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        .info-card p {
            margin: 8px 0;
            font-size: 14px;
        }
        .info-card strong {
            color: #1e293b; /* slate-800 */
            display: inline-block;
            width: 120px;
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
            background-color: #172554; /* brand-950 */
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
        }
        td {
            font-size: 14px;
            color: #475569;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>شركة النظام المتطور (ERP)</h1>
            <h3>مسير راتب شهر {{ now()->translatedFormat('F Y') }}</h3>
        </div>

        <div class="info-card">
            <p><strong>اسم الموظف:</strong> {{ $employee->name }}</p>
            <p><strong>الإيميل:</strong> {{ $employee->email }}</p>
            <p><strong>المسمى الوظيفي:</strong> {{ $employee->job_title ?? 'غير محدد' }}</p>
            <p><strong>القسم:</strong> {{ $employee->department ?? 'غير محدد' }}</p>
            <p><strong>رقم الجوال:</strong> <span dir="ltr">{{ $employee->phone ?? 'غير محدد' }}</span></p>
        </div>
        
        @php
            $baseSalary = $employee->salary ?? rand(5000, 15000);
            $allowances = rand(500, 2000);
            $total = $baseSalary + $allowances;
        @endphp

        <table>
            <thead>
                <tr>
                    <th>البيان (Description)</th>
                    <th style="text-align: left;">المبلغ (Amount)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>الراتب الأساسي (Base Salary)</td>
                    <td style="text-align: left; font-family: monospace;">{{ number_format($baseSalary, 2) }} ر.س</td> 
                </tr>
                <tr>
                    <td>البدلات (Allowances)</td>
                    <td style="text-align: left; font-family: monospace;">{{ number_format($allowances, 2) }} ر.س</td>
                </tr>
                <tr class="total-row">
                    <td>إجمالي الراتب (Total Salary)</td>
                    <td style="text-align: left; font-family: monospace; color: #166534;">{{ number_format($total, 2) }} ر.س</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>هذا المستند تم إصداره آلياً من النظام، ولا يحتاج إلى توقيع.</p>
            <p>تاريخ الإصدار: {{ now()->translatedFormat('l، j F Y') }}</p>
        </div>
    </div>
</body>
</html>
