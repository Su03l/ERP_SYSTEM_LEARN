<x-app-layout>
    <x-slot name="header">تعديل التقييم</x-slot>

    <div class="max-w-3xl mx-auto">
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

            <form method="POST" action="{{ route('performance.update', $performance) }}" class="p-6 space-y-8" x-data="editForm()">
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
                            <option value="monthly" {{ $performance->evaluation_period === 'monthly' ? 'selected' : '' }}>شهري</option>
                            <option value="quarterly" {{ $performance->evaluation_period === 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                            <option value="yearly" {{ $performance->evaluation_period === 'yearly' ? 'selected' : '' }}>سنوي</option>
                        </select>
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- معايير التقييم --}}
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-brand-100 pb-3">
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
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition resize-none">{{ old('notes', $performance->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-brand-100">
                    <a href="{{ route('performance.show', $performance) }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        ← العودة للتفاصيل
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editForm() {
            return {
                ratings: {
                    overall_rating: {{ $performance->overall_rating }},
                    commitment_rating: {{ $performance->commitment_rating }},
                    teamwork_rating: {{ $performance->teamwork_rating }},
                    creativity_rating: {{ $performance->creativity_rating }},
                    communication_rating: {{ $performance->communication_rating }},
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
                }
            }
        }
    </script>
</x-app-layout>
