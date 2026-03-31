<x-app-layout>
    <x-slot name="header">تقييم الأداء</x-slot>

    {{-- Top Section: Search & Create --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

        {{-- بطاقة إنشاء تقييم جديد --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
            <div class="bg-gradient-to-l from-brand-900 to-brand-950 p-6 text-white">
                <h2 class="text-lg font-black flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    تقييم أداء جديد
                </h2>
                <p class="text-brand-200 text-sm mt-2">أدخل رقم الموظف للبدء بعملية التقييم</p>
            </div>

            <div class="p-6" x-data="performanceForm()">
                {{-- البحث عن الموظف --}}
                <div class="flex items-end gap-4 mb-6">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-brand-800 mb-2">رقم الموظف</label>
                        <input type="text" x-model="searchQuery" @keydown.enter.prevent="searchEmployee()"
                            class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition"
                            placeholder="أدخل رقم الموظف مثال: EMP-001" dir="ltr">
                    </div>
                    <button @click="searchEmployee()" type="button"
                        class="px-6 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] flex items-center gap-2 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        بحث
                    </button>
                </div>

                {{-- رسالة خطأ --}}
                <div x-show="searchError" x-transition x-cloak class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span x-text="searchError"></span>
                </div>

                {{-- بطاقة الموظف --}}
                <div x-show="employee" x-transition x-cloak class="mb-6 p-5 bg-brand-50/50 border border-brand-100 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-brand-950 rounded-xl flex items-center justify-center text-white text-xl font-black shrink-0" x-text="employee?.avatar_initial"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg font-black text-brand-950 truncate" x-text="employee?.name"></p>
                            <div class="flex flex-wrap items-center gap-3 mt-1">
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 bg-brand-100 px-2 py-0.5 rounded-md" x-text="employee?.employee_number"></span>
                                <span class="text-xs text-brand-500" x-text="employee?.job_title"></span>
                                <span class="text-xs text-brand-400">•</span>
                                <span class="text-xs text-brand-500" x-text="employee?.department"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- نموذج التقييم --}}
                <form x-show="employee" x-transition x-cloak method="POST" action="{{ route('performance.store') }}">
                    @csrf
                    <input type="hidden" name="employee_id" :value="employee?.id">

                    <div class="space-y-6">
                        {{-- فترة التقييم --}}
                        <div>
                            <label class="block text-sm font-bold text-brand-800 mb-2">فترة التقييم</label>
                            <div class="relative">
                                <select name="evaluation_period" required
                                    class="w-full pl-10 pr-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition appearance-none">
                                    <option value="">-- اختر الفترة --</option>
                                    <option value="monthly">شهري</option>
                                    <option value="quarterly">ربع سنوي</option>
                                    <option value="yearly">سنوي</option>
                                </select>
                                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>

                        {{-- معايير التقييم --}}
                        <div class="space-y-5">
                            <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider flex items-center gap-2 border-b border-brand-100 pb-3">
                                <span class="w-6 h-6 bg-brand-950 text-white rounded-md flex items-center justify-center text-xs">★</span>
                                معايير التقييم
                            </h4>

                            <template x-for="criteria in ratingCriteria" :key="criteria.name">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-brand-50/30 rounded-xl border border-brand-50 hover:border-brand-200 transition">
                                    <div>
                                        <p class="text-sm font-bold text-brand-900" x-text="criteria.label"></p>
                                        <p class="text-xs text-brand-500 mt-0.5" x-text="criteria.desc"></p>
                                    </div>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <template x-for="star in 5" :key="star">
                                            <button type="button" @click="setRating(criteria.name, star)"
                                                :class="star <= ratings[criteria.name] ? 'text-amber-400' : 'text-brand-200 hover:text-amber-300'"
                                                class="transition-colors duration-150 transform hover:scale-110 active:scale-95">
                                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </button>
                                        </template>
                                        <input type="hidden" :name="criteria.name" :value="ratings[criteria.name]">
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- الملاحظات --}}
                        <div>
                            <label class="block text-sm font-bold text-brand-800 mb-2">ملاحظات المشرف</label>
                            <textarea name="notes" rows="4"
                                class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition resize-none"
                                placeholder="أضف ملاحظاتك وتعليقاتك على أداء الموظف..."></textarea>
                        </div>

                        {{-- زر الحفظ --}}
                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="px-8 py-3 bg-brand-950 text-white font-black rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] shadow-md shadow-brand-950/20 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                حفظ التقييم
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- بطاقة الإحصائيات --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-6 animate-fade-in">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-sm font-black text-brand-900">ملخص التقييمات</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                        <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">إجمالي التقييمات</p>
                        <p class="text-2xl font-black text-brand-900">{{ $evaluations->total() }}</p>
                    </div>
                    <div class="bg-amber-50/50 rounded-xl p-4 border border-amber-100 text-center">
                        <p class="text-[10px] font-black uppercase text-amber-500 tracking-widest mb-1">هذا الشهر</p>
                        <p class="text-2xl font-black text-amber-600">{{ \App\Models\PerformanceEvaluation::whereMonth('created_at', now()->month)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-brand-900 to-brand-950 rounded-2xl shadow-sm p-6 text-white animate-fade-in">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                </div>
                <h4 class="font-black text-lg mb-2">نصيحة</h4>
                <p class="text-sm text-brand-200 leading-relaxed">قم بإجراء تقييمات دورية للموظفين لتحسين الأداء العام. التقييم المنتظم يساعد على تطوير المهارات وتحسين بيئة العمل.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-xl p-4 animate-fade-in flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-xl p-4 animate-fade-in">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- سجل التقييمات السابقة --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
        <div class="p-6 border-b border-brand-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="text-lg font-black text-brand-950 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                سجل التقييمات
            </h3>
            <form action="{{ route('performance.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" placeholder="بحث بالاسم أو رقم الموظف..."
                       value="{{ request('search') }}"
                       class="border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    بحث
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b border-brand-100 bg-white">
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">الموظف</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">الفترة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">المتوسط</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">المقيِّم</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">التاريخ</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($evaluations as $evaluation)
                        <tr class="hover:bg-brand-50/50 transition-all duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-brand-950 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        {{ mb_substr($evaluation->employee->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-brand-900">{{ $evaluation->employee->name }}</p>
                                        <p class="text-xs text-brand-400">{{ $evaluation->employee->employee_number ?? '#'.$evaluation->employee->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-lg
                                    {{ $evaluation->evaluation_period === 'yearly' ? 'bg-purple-50 text-purple-700' : ($evaluation->evaluation_period === 'quarterly' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700') }}">
                                    {{ $evaluation->period_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($evaluation->average_rating) ? 'text-amber-400' : 'text-brand-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-bold text-brand-700">{{ $evaluation->average_rating }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $evaluation->evaluator->name }}</td>
                            <td class="px-6 py-4 text-sm text-brand-500" dir="ltr">{{ $evaluation->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('performance.show', $evaluation) }}" class="p-2 text-brand-400 hover:text-brand-900 hover:bg-brand-100 rounded-lg transition-colors" title="عرض">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </a>
                                    <a href="{{ route('performance.pdf', $evaluation) }}" class="p-2 text-brand-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="تصدير PDF" target="_blank">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </a>
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('performance.edit', $evaluation) }}" class="p-2 text-brand-400 hover:text-brand-900 hover:bg-brand-100 rounded-lg transition-colors" title="تعديل">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                <p class="text-brand-400 text-lg">لا توجد تقييمات مسجلة حتى الآن</p>
                                <p class="text-brand-300 text-sm mt-1">ابدأ بتقييم أداء الموظفين من النموذج أعلاه</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $evaluations->links() }}
    </div>

    <script>
        function performanceForm() {
            return {
                searchQuery: '',
                employee: null,
                searchError: '',
                ratings: {
                    overall_rating: 0,
                    commitment_rating: 0,
                    teamwork_rating: 0,
                    creativity_rating: 0,
                    communication_rating: 0,
                },
                ratingCriteria: [
                    { name: 'overall_rating', label: 'الأداء العام', desc: 'تقييم الأداء الوظيفي العام والكفاءة في إنجاز المهام' },
                    { name: 'commitment_rating', label: 'الالتزام', desc: 'مدى الالتزام بالمواعيد واللوائح والأنظمة' },
                    { name: 'teamwork_rating', label: 'العمل الجماعي', desc: 'التعاون مع الزملاء والعمل ضمن الفريق' },
                    { name: 'creativity_rating', label: 'الإبداع والمبادرة', desc: 'القدرة على تقديم أفكار وحلول إبداعية' },
                    { name: 'communication_rating', label: 'التواصل', desc: 'مهارات التواصل الفعّال مع الزملاء والعملاء' },
                ],
                setRating(name, value) {
                    this.ratings[name] = value;
                },
                async searchEmployee() {
                    if (!this.searchQuery.trim()) {
                        this.searchError = 'يرجى إدخال رقم الموظف';
                        return;
                    }
                    this.searchError = '';
                    this.employee = null;
                    try {
                        const response = await fetch(`{{ route('performance.search') }}?query=${encodeURIComponent(this.searchQuery)}`);
                        const data = await response.json();
                        if (data.found) {
                            this.employee = data.employee;
                            // Reset ratings
                            Object.keys(this.ratings).forEach(k => this.ratings[k] = 0);
                        } else {
                            this.searchError = 'لم يتم العثور على موظف بهذا الرقم. تأكد من صحة الرقم الوظيفي.';
                        }
                    } catch (err) {
                        this.searchError = 'حدث خطأ أثناء البحث. يرجى المحاولة مرة أخرى.';
                    }
                }
            }
        }
    </script>
</x-app-layout>
