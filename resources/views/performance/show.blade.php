<x-app-layout>
    <x-slot name="header">تفاصيل التقييم</x-slot>

    @php $structure = \App\Models\PerformanceEvaluation::criteriaStructure(); @endphp

    <div class="max-w-5xl mx-auto">
        @if(session('success'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
            {{-- Header --}}
            <div class="bg-gradient-to-l from-brand-900 to-brand-950 p-6 text-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-2xl font-black">
                            {{ mb_substr($performance->employee->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-black">{{ $performance->employee->name }}</h2>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-sm text-brand-200">{{ $performance->employee->employee_number ?? '#'.$performance->employee->id }}</span>
                                <span class="text-brand-400">•</span>
                                <span class="text-sm text-brand-200">{{ $performance->employee->job_title ?? 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('performance.pdf', $performance) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 text-white font-bold rounded-xl hover:bg-white/20 transition text-sm border border-white/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            تصدير PDF
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('performance.edit', $performance) }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-brand-950 font-bold rounded-xl hover:bg-brand-100 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                تعديل
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 space-y-8">
                {{-- ملخص النتائج --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                        <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">فترة التقييم</p>
                        <p class="text-lg font-black text-brand-900">{{ $performance->period_label }}</p>
                    </div>
                    <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                        <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">النقاط</p>
                        <p class="text-lg font-black text-brand-900">{{ $performance->total_score }} <span class="text-xs text-brand-400">/ 100</span></p>
                    </div>
                    <div class="bg-amber-50/50 rounded-xl p-4 border border-amber-100 text-center">
                        <p class="text-[10px] font-black uppercase text-amber-500 tracking-widest mb-1">النسبة المئوية</p>
                        <p class="text-2xl font-black text-amber-600">{{ $performance->percentage }}%</p>
                    </div>
                    @php $gc = $performance->grade_color; @endphp
                    <div class="rounded-xl p-4 border text-center {{ $gc === 'green' ? 'bg-green-50 border-green-200' : ($gc === 'blue' ? 'bg-blue-50 border-blue-200' : ($gc === 'yellow' ? 'bg-yellow-50 border-yellow-200' : ($gc === 'orange' ? 'bg-orange-50 border-orange-200' : 'bg-red-50 border-red-200'))) }}">
                        <p class="text-[10px] font-black uppercase tracking-widest mb-1 {{ $gc === 'green' ? 'text-green-500' : ($gc === 'blue' ? 'text-blue-500' : ($gc === 'yellow' ? 'text-yellow-500' : ($gc === 'orange' ? 'text-orange-500' : 'text-red-500'))) }}">التقدير العام</p>
                        <p class="text-lg font-black {{ $gc === 'green' ? 'text-green-700' : ($gc === 'blue' ? 'text-blue-700' : ($gc === 'yellow' ? 'text-yellow-700' : ($gc === 'orange' ? 'text-orange-700' : 'text-red-700'))) }}">{{ $performance->grade }}</p>
                    </div>
                </div>

                {{-- تفاصيل المعايير --}}
                @foreach($structure as $catKey => $category)
                    @php $score = $performance->getCategoryScore($catKey); @endphp
                    <div class="border border-brand-100 rounded-2xl overflow-hidden">
                        <div class="bg-brand-950 text-white px-5 py-3 flex items-center justify-between">
                            <h4 class="text-sm font-black">{{ $category['label'] }}</h4>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold bg-white/10 px-2.5 py-1 rounded-md">الوزن: {{ $category['weight'] }}</span>
                                <span class="text-xs font-bold bg-white/20 px-2.5 py-1 rounded-md">{{ $score['weighted'] }} / {{ $category['weight'] }}</span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-right">
                                <thead>
                                    <tr class="border-b border-brand-100 bg-brand-50/50">
                                        <th class="px-5 py-3 text-xs font-bold text-brand-500 w-1/2">مؤشر القياس</th>
                                        <th class="px-5 py-3 text-xs font-bold text-brand-500 text-center w-24">المستهدف</th>
                                        <th class="px-5 py-3 text-xs font-bold text-brand-500 text-center w-24">المحقق</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-brand-50">
                                    @foreach($category['items'] as $itemKey => $itemLabel)
                                        @php $val = $performance->ratings[$itemKey] ?? 0; @endphp
                                        <tr>
                                            <td class="px-5 py-3 text-sm text-brand-800">{{ $itemLabel }}</td>
                                            <td class="px-5 py-3 text-center text-sm font-bold text-brand-400">5</td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-sm font-black
                                                    {{ $val >= 4 ? 'bg-green-100 text-green-700' : ($val >= 3 ? 'bg-yellow-100 text-yellow-700' : ($val >= 1 ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700')) }}">
                                                    {{ $val }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                {{-- ملاحظات --}}
                @if($performance->notes)
                    <div>
                        <h4 class="text-sm font-bold text-brand-900 mb-3 flex items-center gap-2 border-b border-brand-100 pb-3">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            ملاحظات المشرف
                        </h4>
                        <div class="bg-brand-50/50 rounded-xl p-5 border border-brand-100">
                            <p class="text-sm text-brand-700 leading-relaxed whitespace-pre-line">{{ $performance->notes }}</p>
                        </div>
                    </div>
                @endif

                {{-- المقيّم --}}
                <div class="bg-brand-50/30 rounded-xl p-4 border border-brand-100 flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-200 rounded-full flex items-center justify-center text-brand-700 text-sm font-bold shrink-0">
                        {{ mb_substr($performance->evaluator->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs text-brand-500">تم التقييم بواسطة</p>
                        <p class="text-sm font-bold text-brand-900">{{ $performance->evaluator->name }} — {{ $performance->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('performance.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15l-3-3m0 0l3-3m-3 3h12"/></svg>
                العودة لسجل التقييمات
            </a>
        </div>
    </div>
</x-app-layout>
