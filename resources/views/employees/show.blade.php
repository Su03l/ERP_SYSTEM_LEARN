<x-app-layout>
    <x-slot name="header">تفاصيل الموظف</x-slot>

    <div class="max-w-4xl">
        {{-- Employee Header Card --}}
        <div class="bg-white rounded-xl border border-brand-200 mb-6 animate-fade-in">
            <div class="p-6 flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="w-20 h-20 bg-brand-950 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shrink-0">
                    {{ mb_substr($employee->name, 0, 2) }}
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <h2 class="text-2xl font-extrabold text-brand-900">{{ $employee->name }}</h2>
                        <x-badge :status="$employee->status ?? 'active'" />
                    </div>
                    <p class="text-brand-500">{{ $employee->job_title ?? 'غير محدد' }} — {{ $employee->department ?? 'غير محدد' }}</p>
                    @if($employee->join_date)
                        <p class="text-xs text-brand-400 mt-1">انضم في {{ $employee->join_date->translatedFormat('j F Y') }}</p>
                    @endif
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('employees.edit', $employee) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-950 text-white font-semibold rounded-xl hover:bg-brand-800 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        تعديل
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Contact Info --}}
            <div class="bg-white rounded-xl border border-brand-200 animate-fade-in stagger-1">
                <div class="p-6 border-b border-brand-100">
                    <h3 class="text-base font-bold text-brand-900">معلومات التواصل</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">البريد الإلكتروني</p>
                        <p class="text-sm text-brand-900 font-medium" dir="ltr">{{ $employee->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">رقم الجوال</p>
                        <p class="text-sm text-brand-900 font-medium" dir="ltr">{{ $employee->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">رقم الطوارئ</p>
                        <p class="text-sm text-brand-900 font-medium" dir="ltr">{{ $employee->emergency_contact ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">العنوان</p>
                        <p class="text-sm text-brand-900 font-medium">{{ $employee->address ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="bg-white rounded-xl border border-brand-200 animate-fade-in stagger-2">
                <div class="p-6 border-b border-brand-100">
                    <h3 class="text-base font-bold text-brand-900">المعلومات الشخصية</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">رقم الهوية</p>
                        <p class="text-sm text-brand-900 font-medium font-mono" dir="ltr">{{ $employee->national_id ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">الجنس</p>
                        <p class="text-sm text-brand-900 font-medium">
                            @if($employee->gender === 'male') ذكر
                            @elseif($employee->gender === 'female') أنثى
                            @else — @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">تاريخ الميلاد</p>
                        <p class="text-sm text-brand-900 font-medium">{{ $employee->birth_date ? $employee->birth_date->translatedFormat('j F Y') : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">تاريخ الإضافة</p>
                        <p class="text-sm text-brand-900 font-medium">{{ $employee->created_at->translatedFormat('j F Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Financial Info --}}
            <div class="bg-white rounded-xl border border-brand-200 animate-fade-in stagger-3">
                <div class="p-6 border-b border-brand-100">
                    <h3 class="text-base font-bold text-brand-900">المعلومات المالية</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">الراتب الشهري</p>
                        <p class="text-2xl font-extrabold text-brand-900">
                            @if($employee->salary)
                                {{ number_format($employee->salary, 2) }} <span class="text-sm font-medium text-brand-400">ر.س</span>
                            @else
                                —
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">رقم الآيبان</p>
                        <p class="text-sm text-brand-900 font-medium font-mono" dir="ltr">{{ $employee->bank_iban ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-400 font-medium uppercase tracking-wider mb-1">تاريخ الالتحاق</p>
                        <p class="text-sm text-brand-900 font-medium">{{ $employee->join_date ? $employee->join_date->translatedFormat('j F Y') : '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tickets --}}
        <div class="bg-white rounded-xl border border-brand-200 mt-6 animate-fade-in stagger-4">
            <div class="flex items-center justify-between p-6 border-b border-brand-100">
                <h3 class="text-base font-bold text-brand-900">التذاكر</h3>
                <span class="text-xs bg-brand-100 text-brand-600 px-2.5 py-1 rounded-full font-semibold">{{ $employee->tickets->count() }}</span>
            </div>
            <div class="divide-y divide-brand-100">
                @forelse($employee->tickets->take(5) as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="flex items-center justify-between p-4 hover:bg-brand-50 transition-colors">
                        <div>
                            <p class="text-sm font-semibold text-brand-900">{{ $ticket->subject }}</p>
                            <p class="text-xs text-brand-400">{{ $ticket->ticket_number }} • {{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        <x-badge :status="$ticket->status" />
                    </a>
                @empty
                    <div class="p-6 text-center text-brand-400 text-sm">لا توجد تذاكر</div>
                @endforelse
            </div>
        </div>

        {{-- Leave History --}}
        <div class="bg-white rounded-xl border border-brand-200 mt-6 animate-fade-in stagger-5">
            <div class="flex items-center justify-between p-6 border-b border-brand-100">
                <h3 class="text-base font-bold text-brand-900">سجل الإجازات</h3>
                <span class="text-xs bg-brand-100 text-brand-600 px-2.5 py-1 rounded-full font-semibold">{{ $employee->leaveRequests->count() }}</span>
            </div>
            <div class="divide-y divide-brand-100">
                @forelse($employee->leaveRequests->take(5) as $leave)
                    <div class="flex items-center justify-between p-4 hover:bg-brand-50 transition-colors">
                        <div>
                            <p class="text-sm font-semibold text-brand-900">{{ $leave->reason }}</p>
                            <p class="text-xs text-brand-400">{{ $leave->start_date->format('Y/m/d') }} — {{ $leave->end_date->format('Y/m/d') }}</p>
                        </div>
                        <x-badge :status="$leave->status" />
                    </div>
                @empty
                    <div class="p-6 text-center text-brand-400 text-sm">لا توجد طلبات إجازة</div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('employees.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                ← العودة لقائمة الموظفين
            </a>
        </div>
    </div>
</x-app-layout>
