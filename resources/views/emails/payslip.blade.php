<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تفاصيل الراتب - مسير شهر {{ now()->translatedFormat('F') }}</title>
    <!-- start the style -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, system-ui;
            background-color: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }

        /* start the header */
        .header {
            background-color: #172554;
            /* brand-950 */
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #bfdbfe;
            /* blue-200 */
            font-size: 15px;
        }

        .content {
            padding: 30px;
            color: #334155;
        }

        .content h2 {
            color: #0f172a;
            font-size: 20px;
            margin-top: 0;
        }

        .message-box {
            background-color: #f1f5f9;
            border-right: 4px solid #172554;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .message-box p {
            margin: 0;
            font-size: 15px;
        }

        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <h1>شركة النظام المتطور (ERP)</h1>
                <p>مسير راتب شهر {{ now()->translatedFormat('F Y') }}</p>
            </div>

            <div class="content">
                <h2>أهلاً بك {{ $employee->name }}،</h2>

                <p>نأمل أن تكون بأفضل حال.</p>

                <div class="message-box">
                    <p>مرفق طيه ملف يحتوي على تفاصيل مسير راتبك الخاص بشهر {{ now()->translatedFormat('F Y') }}.</p>
                </div>

                <p>يرجى الاطلاع على المرفق للحصول على تفاصيل الراتب الأساسي والبدلات. إذا كان لديك أي استفسارات، نرجو عدم التردد في التواصل مع قسم الموارد البشرية.</p>

                <p style="margin-top: 30px;">
                    مع خالص التحيات،<br>
                    <strong>إدارة الموارد البشرية</strong>
                </p>
            </div>

            <div class="footer">
                <p>هذه رسالة تلقائية من نظام ERP. يُرجى عدم الرد المباشر على هذا البريد.</p>
                <p>&copy; {{ date('Y') }} شركة النظام المتطور. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </div>
</body>

</html>