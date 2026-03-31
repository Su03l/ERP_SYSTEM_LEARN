<x-app-layout>
    <x-slot name="header">تفاصيل التقييم</x-slot>

    <div class="max-w-4xl mx-auto">

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
                {{-- معلومات عامة --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                        <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">فترة التقييم</p>
                        <p class="text-lg font-black text-brand-900">{{ $performance->period_label }}</p>
                    </div>
                    <div class="bg-amber-50/50 rounded-xl p-4 border border-amber-100 text-center">
                        <p class="text-[10px] font-black uppercase text-amber-500 tracking-widest mb-1">المتوسط العام</p>
                        <div class="flex items-center justify-center gap-2">
                            <p class="text-2xl font-black text-amber-600">{{ $performance->average_rating }}</p>
                            <span class="text-sm text-amber-400">/ 5</span>
                        </div>
                    </div>
                    <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 text-center">
                        <p class="text-[10px] font-black uppercase text-brand-400 tracking-widest mb-1">تاريخ التقييم</p>
                        <p class="text-lg font-black text-brand-900" dir="ltr">{{ $performance->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>

                {{-- تفاصيل التقييم --}}
                <div>
                    <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-brand-100 pb-3">
                        <span class="w-6 h-6 bg-brand-950 text-white rounded-md flex items-center justify-center text-xs">★</span>
                        تفاصيل المعايير
                    </h4>

                    <div class="space-y-3">
                        @php
                            $criteria = [
                                ['label' => 'الأداء العام', 'value' => $performance->overall_rating, 'desc' => 'الكفاءة في إنجاز المهام'],
                                ['label' => 'الالتزام', 'value' => $performance->commitment_rating, 'desc' => 'الالتزام بالمواعيد واللوائح'],
                                ['label' => 'العمل الجماعي', 'value' => $performance->teamwork_rating, 'desc' => 'التعاون ضمن الفريق'],
                                ['label' => 'الإبداع والمبادرة', 'value' => $performance->creativity_rating, 'desc' => 'تقديم حلول إبداعية'],
                                ['label' => 'التواصل', 'value' => $performance->communication_rating, 'desc' => 'التواصل الفعّال'],
                            ];
                        @endphp

                        @foreach($criteria as $item)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-brand-50/30 rounded-xl border border-brand-50">
                                <div>
                                    <p class="text-sm font-bold text-brand-900">{{ $item['label'] }}</p>
                                    <p class="text-xs text-brand-500 mt-0.5">{{ $item['desc'] }}</p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-6 h-6 {{ $i <= $item['value'] ? 'text-amber-400' : 'text-brand-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-bold text-brand-700 w-8 text-center">{{ $item['value'] }}/5</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ملاحظات المشرف --}}
                @if($performance->notes)
                    <div>
                        <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-3 flex items-center gap-2 border-b border-brand-100 pb-3">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            ملاحظات المشرف
                        </h4>
                        <div class="bg-brand-50/50 rounded-xl p-5 border border-brand-100">
                            <p class="text-sm text-brand-700 leading-relaxed whitespace-pre-line">{{ $performance->notes }}</p>
                        </div>
                    </div>
                @endif

                {{-- معلومات المقيّم --}}
                <div class="bg-brand-50/30 rounded-xl p-4 border border-brand-100 flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-200 rounded-full flex items-center justify-center text-brand-700 text-sm font-bold shrink-0">
                        {{ mb_substr($performance->evaluator->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs text-brand-500">تم التقييم بواسطة</p>
                        <p class="text-sm font-bold text-brand-900">{{ $performance->evaluator->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- رابط العودة --}}
        <div class="mt-6">
            <a href="{{ route('performance.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15l-3-3m0 0l3-3m-3 3h12"/></svg>
                العودة لسجل التقييمات
            </a>
        </div>
    </div>
</x-app-layout>
