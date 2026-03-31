<x-app-layout>
    <x-slot name="header">تعديل التقييم</x-slot>

    @php
        $structure = \App\Models\PerformanceEvaluation::criteriaStructure();
        $periods = \App\Models\PerformanceEvaluation::periodOptions();
    @endphp

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in">
            <div class="p-6 border-b border-brand-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-brand-950 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        {{ mb_substr($performance->employee->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-brand-900">{{ $performance->employee->name }}</h3>
                        <p class="text-sm text-brand-500">تعديل تقييم الأداء — {{ $performance->period_label }}</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('performance.update', $performance) }}" class="p-6 space-y-8">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- فترة التقييم --}}
                <div>
                    <label class="block text-sm font-bold text-brand-800 mb-2">فترة التقييم</label>
                    <div class="relative">
                        <select name="evaluation_period" required
                            class="w-full pl-10 pr-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 transition appearance-none">
                            @foreach($periods as $value => $label)
                                <option value="{{ $value }}" {{ $performance->evaluation_period === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- معايير التقييم --}}
                @foreach($structure as $catKey => $category)
                    <div class="border border-brand-100 rounded-2xl overflow-hidden">
                        <div class="bg-brand-950 text-white px-5 py-3 flex items-center justify-between">
                            <h4 class="text-sm font-black flex items-center gap-2">
                                <span class="w-6 h-6 bg-white/20 rounded flex items-center justify-center text-[10px]">{{ $loop->iteration }}</span>
                                {{ $category['label'] }}
                            </h4>
                            <span class="text-xs font-bold bg-white/10 px-2.5 py-1 rounded-md">الوزن: {{ $category['weight'] }}</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-right">
                                <thead>
                                    <tr class="border-b border-brand-100 bg-brand-50/50">
                                        <th class="px-5 py-3 text-xs font-bold text-brand-500 w-1/2">مؤشر القياس</th>
                                        <th class="px-5 py-3 text-xs font-bold text-brand-500 text-center w-24">المستهدف</th>
                                        <th class="px-5 py-3 text-xs font-bold text-brand-500 text-center w-32">المحقق</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-brand-50">
                                    @foreach($category['items'] as $itemKey => $itemLabel)
                                        <tr class="hover:bg-brand-50/30 transition">
                                            <td class="px-5 py-3 text-sm text-brand-800">{{ $itemLabel }}</td>
                                            <td class="px-5 py-3 text-center text-sm font-bold text-brand-400">5</td>
                                            <td class="px-5 py-3 text-center">
                                                <select name="ratings[{{ $itemKey }}]" required
                                                    class="w-20 mx-auto px-2 py-1.5 bg-white border border-brand-200 rounded-lg text-sm text-brand-900 font-bold text-center focus:outline-none focus:ring-2 focus:ring-brand-900 transition appearance-none">
                                                    @for($i = 0; $i <= 5; $i++)
                                                        <option value="{{ $i }}" {{ ($performance->ratings[$itemKey] ?? 0) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                {{-- الملاحظات --}}
                <div>
                    <label class="block text-sm font-bold text-brand-800 mb-2">ملاحظات المشرف</label>
                    <textarea name="notes" rows="4"
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition resize-none">{{ old('notes', $performance->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-brand-100">
                    <a href="{{ route('performance.show', $performance) }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">← العودة للتفاصيل</a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
