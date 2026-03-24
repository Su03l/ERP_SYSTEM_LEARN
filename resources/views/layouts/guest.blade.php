<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ERP System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        {{-- ─── Left: Branding Panel (Black) ─── --}}
        <div class="hidden lg:flex lg:w-1/2 bg-brand-950 text-white flex-col justify-between p-12 relative overflow-hidden">
            {{-- Abstract pattern --}}
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-20 right-20 w-96 h-96 border border-white rounded-full"></div>
                <div class="absolute bottom-20 left-20 w-64 h-64 border border-white rounded-full"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] border border-white rounded-full"></div>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-950" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-3.14 1.346 2.352 1.008a1 1 0 00.788 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight">ERP System</span>
                </div>
            </div>

            <div class="relative z-10 space-y-6">
                <h2 class="text-4xl font-extrabold leading-tight">
                    نظام إدارة<br>
                    الموارد البشرية
                </h2>
                <p class="text-brand-400 text-lg max-w-md">
                    منصة متكاملة لإدارة الموظفين والتذاكر وطلبات الإجازة بكفاءة عالية
                </p>
                <div class="flex gap-8 pt-4">
                    <div>
                        <p class="text-3xl font-bold">+500</p>
                        <p class="text-brand-500 text-sm">موظف نشط</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">99%</p>
                        <p class="text-brand-500 text-sm">وقت التشغيل</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">24/7</p>
                        <p class="text-brand-500 text-sm">دعم فني</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-brand-600 text-sm">© {{ date('Y') }} ERP System. جميع الحقوق محفوظة.</p>
            </div>
        </div>

        {{-- ─── Right: Form Area (White) ─── --}}
        <div class="flex-1 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md animate-fade-in">
                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center gap-3 mb-10 justify-center">
                    <div class="w-10 h-10 bg-brand-950 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-3.14 1.346 2.352 1.008a1 1 0 00.788 0l7-3a1 1 0 000-1.838l-7-3z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-brand-900">ERP System</span>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
