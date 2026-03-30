<x-app-layout>
    <x-slot name="header">ملف السجل الوظيفي</x-slot>

    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
        
        {{-- ─── Identity Sidebar (1/3 width) ─── --}}
        <div class="lg:w-96 space-y-6 shrink-0">
            
            {{-- Employee Identity Card --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden relative">
                <div class="h-24 bg-brand-900 relative">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')]"></div>
                </div>
                
                <div class="px-6 pb-6 pt-0 relative text-center">
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 p-1.5 bg-white rounded-2xl border border-brand-100 shadow-sm z-10 w-24 h-24">
                        <div class="w-full h-full rounded-xl overflow-hidden bg-brand-50 flex items-center justify-center text-3xl font-black text-brand-900 border border-brand-100">
                            @if($employee->avatar ?? false)
                                <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover">
                            @else
                                {{ mb_substr($employee->name, 0, 1) }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="pt-16">
                        <x-badge :status="$employee->status ?? 'active'" />
                        <h3 class="text-xl font-black text-brand-950 truncate mt-3">{{ $employee->name }}</h3>
                        <p class="text-sm font-medium text-brand-500 truncate mt-1" dir="ltr">{{ $employee->email }}</p>
                        
                        <div class="mt-5 flex items-center justify-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-50 text-brand-700 text-xs font-bold rounded-lg border border-brand-100 uppercase tracking-wider">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                درجات الصلاحية: {{ $employee->role === 'admin' ? 'مدير نظام' : 'موظف' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-brand-50">
                        <a href="{{ route('employees.edit', $employee) }}" class="w-full px-4 py-2.5 bg-brand-900 text-white text-sm font-bold rounded-xl hover:bg-brand-800 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"></path></svg>
                            تعديل بيانات السجل
                        </a>
                    </div>
                </div>
            </div>

            {{-- Quick Overview Status --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6 grid grid-cols-2 gap-4">
                <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                    <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">الرصيد المتاح</p>
                    <p class="text-xl font-black text-brand-900">{{ 21 }} <span class="text-xs font-bold text-brand-500">يوم</span></p> {{-- Static for UI --}}
                </div>
                <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                    <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">مدد الخدمة</p>
                    <p class="text-xl font-black text-brand-900">{{ $employee->join_date ? $employee->join_date->diffInMonths(now()) : 0 }} <span class="text-xs font-bold text-brand-500">شهر</span></p>
                </div>
            </div>

        </div>

        {{-- ─── Main Content Area (2/3 width) ─── --}}
        <div class="flex-1 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3 shadow-sm animate-fade-in">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Mega Profile Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">
                <div class="border-b border-brand-100 bg-brand-50/30 p-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black text-brand-950">{{ $employee->job_title ?? 'موظف بانتظار التسكين' }}</h2>
                        <p class="text-sm font-bold text-brand-600 mt-1">قسم: {{ $employee->department ?? 'غير محدد' }}</p>
                    </div>
                    @if($employee->join_date)
                    <div class="text-left">
                        <p class="text-xs font-semibold text-brand-400 uppercase tracking-widest mb-1">تاريخ المباشرة</p>
                        <p class="text-sm font-bold text-brand-900" dir="ltr">{{ $employee->join_date->format('Y-m-d') }}</p>
                    </div>
                    @endif
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Column 1: Personal --}}
                    <div class="space-y-5">
                        <h3 class="text-sm font-bold text-brand-900 border-b border-brand-100 pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            بيانات شخصية
                        </h3>
                        <div>
                            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest mb-1">الرقم الوطني / الإقامة</p>
                            <p class="text-sm font-bold text-brand-900 font-mono" dir="ltr">{{ $employee->national_id ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest mb-1">تاريخ الميلاد</p>
                            <p class="text-sm font-bold text-brand-900" dir="ltr">{{ $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '---' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest mb-1">الجنس</p>
                            <p class="text-sm font-bold text-brand-900">
                                @if($employee->gender === 'male') ذكر
                                @elseif($employee->gender === 'female') أنثى
                                @else غير مسجل @endif
                            </p>
                        </div>
                    </div>

                    {{-- Column 2: Contact --}}
                    <div class="space-y-5">
                        <h3 class="text-sm font-bold text-brand-900 border-b border-brand-100 pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            التواصل والطوارئ
                        </h3>
                        <div>
                            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest mb-1">الجوال الخاص</p>
                            <p class="text-sm font-bold text-brand-900 font-mono" dir="ltr">{{ $employee->phone ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest mb-1">اتصال بحالة الطوارئ</p>
                            <p class="text-sm font-bold text-brand-900 font-mono" dir="ltr">{{ $employee->emergency_contact ?? '---' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest mb-1">العنوان الوطني</p>
                            <p class="text-sm font-bold text-brand-900 line-clamp-2" title="{{ $employee->address }}">{{ $employee->address ?? '---' }}</p>
                        </div>
                    </div>

                    {{-- Column 3: Financial --}}
                    <div class="space-y-5 bg-brand-50/50 -m-6 p-6 border-r border-brand-100">
                        <h3 class="text-sm font-bold text-brand-900 border-b border-brand-200 pb-2 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            البيانات المالية
                        </h3>
                        <div>
                            <p class="text-[11px] font-bold text-brand-500 uppercase tracking-widest mb-1">الراتب الأساسي</p>
                            @if($employee->salary)
                                <p class="text-2xl font-black text-brand-950 font-mono" dir="ltr">
                                    {{ number_format($employee->salary, 2) }} <span class="text-xs font-bold text-brand-400">SAR</span>
                                </p>
                            @else
                                <p class="text-sm font-bold text-brand-900">غير مسجل</p>
                            @endif
                        </div>
                        <div class="pt-2">
                            <p class="text-[11px] font-bold text-brand-500 uppercase tracking-widest mb-1">الحساب البنكي (IBAN)</p>
                            <p class="text-xs font-bold text-brand-900 font-mono break-all leading-relaxed" dir="ltr">{{ $employee->bank_iban ?? '---' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity & History Split --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                
                {{-- Leave Requests --}}
                <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden flex flex-col">
                    <div class="flex items-center justify-between p-5 border-b border-brand-50 bg-brand-50/20">
                        <h3 class="text-sm font-black text-brand-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            سجل الإجازات
                        </h3>
                        <span class="w-6 h-6 rounded bg-brand-100 text-brand-600 font-bold text-xs flex items-center justify-center">{{ $employee->leaveRequests->count() }}</span>
                    </div>
                    <div class="divide-y divide-brand-50 flex-1">
                        @forelse($employee->leaveRequests->take(4) as $leave)
                            <a href="{{ route('leave-requests.show', $leave) }}" class="flex items-start justify-between p-4 hover:bg-brand-50/50 transition group block">
                                <div>
                                    <p class="text-xs font-bold text-brand-900 group-hover:text-brand-600 transition truncate max-w-[180px]">{{ $leave->reason }}</p>
                                    <p class="text-[10px] font-medium text-brand-400 mt-1" dir="ltr">{{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d') }}</p>
                                </div>
                                <div class="shrink-0 scale-90 origin-left">
                                    <x-badge :status="$leave->status" />
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center flex flex-col items-center justify-center h-full">
                                <div class="w-10 h-10 bg-brand-50 rounded-full flex items-center justify-center text-brand-400 mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-xs font-bold text-brand-400">سجل الإجازات خالي</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Support Tickets --}}
                <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden flex flex-col">
                    <div class="flex items-center justify-between p-5 border-b border-brand-50 bg-brand-50/20">
                        <h3 class="text-sm font-black text-brand-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"></path></svg>
                            تذاكر الدعم הפني
                        </h3>
                        <span class="w-6 h-6 rounded bg-brand-100 text-brand-600 font-bold text-xs flex items-center justify-center">{{ $employee->tickets->count() }}</span>
                    </div>
                    <div class="divide-y divide-brand-50 flex-1">
                        @forelse($employee->tickets->take(4) as $ticket)
                            <a href="{{ route('tickets.show', $ticket) }}" class="flex items-start justify-between p-4 hover:bg-brand-50/50 transition group block">
                                <div>
                                    <p class="text-xs font-bold text-brand-900 group-hover:text-brand-600 transition truncate max-w-[180px]">{{ $ticket->subject }}</p>
                                    <p class="text-[10px] font-medium text-brand-400 mt-1" dir="ltr">{{ $ticket->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="shrink-0 scale-90 origin-left">
                                    <x-badge :status="$ticket->status" />
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center flex flex-col items-center justify-center h-full">
                                <div class="w-10 h-10 bg-brand-50 rounded-full flex items-center justify-center text-brand-400 mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-xs font-bold text-brand-400">لا توجد تذاكر مسجلة</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
