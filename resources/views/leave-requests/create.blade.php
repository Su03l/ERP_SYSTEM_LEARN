<x-app-layout>
    <x-slot name="header">تقديم طلب إجازة جديد</x-slot>

    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
        
        {{-- ─── Instruction Sidebar (1/3 width) ─── --}}
        <div class="lg:w-[350px] shrink-0 order-2 lg:order-1 space-y-6">
            <div class="bg-brand-900 rounded-2xl shadow-sm overflow-hidden text-white">
                <div class="p-6 border-b border-white/10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black tracking-wide mb-1">إرشادات هامة</h3>
                    <p class="text-xs text-brand-200 leading-relaxed font-medium">يرجى قراءة التعليمات التالية لضمان قبول طلبك بسلاسة وسرعة.</p>
                </div>
                <div class="p-6 bg-brand-950/30 space-y-5">
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">الإجازة المرضية:</span> يتطلب النظام إرفاق تقرير طبي رسمي معتمد من جهة صحية لتجنب رفض الطلب.</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">رصيد الإجازات:</span> تأكد من وجود رصيد كافٍ في إجازتك السنوية المجدولة قبل التقديم.</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">الإجازة الطارئة:</span> مخصصة للحالات المفاجئة، ويجب تقديم المبرر الكافي لمديرك لاعتمادها.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-3 text-brand-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-brand-900 mb-1">هل تواجه مشكلة فنية؟</h4>
                <p class="text-xs text-brand-500 mb-4">في حال عدم تمكنك من رفع المرفقات، يمكنك فتح تذكرة دعم فني وسنقوم بالمساعدة.</p>
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-700 hover:text-brand-900 transition underline underline-offset-4">
                    فتح تذكرة دعم
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
            </div>
        </div>

        {{-- ─── Main Form (2/3 width) ─── --}}
        <div class="flex-1 order-1 lg:order-2">
            <form method="POST" action="{{ route('leave-requests.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
                @csrf
                
                <div class="bg-brand-50/50 p-6 sm:p-8 border-b border-brand-100">
                    <h2 class="text-xl font-black text-brand-950 flex items-center gap-2">
                        نموذج الطلب الرسمي
                    </h2>
                    <p class="text-sm text-brand-500 mt-2 font-medium">الرجاء تعبئة المعلومات المطلوبة بدقة تامة لتسهيل إجراءات المراجعة.</p>
                </div>

                <div class="p-6 sm:p-8 space-y-8">
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-xl p-5 flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-red-900 mb-1">يرجى تصحيح الأخطاء التالية:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-xs font-semibold text-red-700">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Type & Dates Section --}}
                    <div class="space-y-6">
                        <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest border-b border-brand-100 pb-2">معلومات الإجازة</h4>
                        
                        <div>
                            <label for="type" class="block text-sm font-bold text-brand-800 mb-2">نوع الإجازة المطلوبة</label>
                            <div class="relative">
                                <select name="type" id="type" required
                                    class="w-full pl-10 pr-4 py-3.5 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition appearance-none">
                                    <option value="">-- اضغط للاختيار --</option>
                                    <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>إجازة سنوية اعتيادية</option>
                                    <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>إجازة مرضية (يتطلب إرفاق تقرير)</option>
                                    <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>إجازة طارئة مستعجلة</option>
                                    <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>إجازة استثنائية (بدون أجر)</option>
                                </select>
                                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-bold text-brand-800 mb-2">تاريخ البدء</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                    class="w-full px-4 py-3.5 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition">
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-bold text-brand-800 mb-2">تاريخ الانتهاء</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                    class="w-full px-4 py-3.5 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition">
                            </div>
                        </div>
                    </div>

                    {{-- Description Section --}}
                    <div class="space-y-6 pt-2">
                        <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest border-b border-brand-100 pb-2">المبررات والمرفقات</h4>
                        
                        <div>
                            <label for="reason" class="block text-sm font-bold text-brand-800 mb-2">سبب الإجازة والتفاصيل المبررة</label>
                            <textarea name="reason" id="reason" rows="5" required
                                class="w-full px-4 py-4 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium placeholder-brand-300 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition resize-none leading-relaxed"
                                placeholder="الرجاء كتابة تفاصيل وافية تساعد الإدارة على فهم سبب الإجازة واعتمادها...">{{ old('reason') }}</textarea>
                        </div>

                        <div class="bg-brand-50/50 rounded-xl border border-brand-200 border-dashed p-6">
                            <label for="attachment" class="block text-sm font-bold text-brand-800 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                المرفقات المؤيدة للطلب (اختياري)
                            </label>
                            <input type="file" name="attachment" id="attachment"
                                class="w-full px-4 py-3 bg-white border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 transition file:mr-4 file:py-2 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-900 file:text-white hover:file:bg-brand-800 cursor-pointer shadow-sm">
                            <p class="text-xs text-brand-500 font-medium mt-3 leading-relaxed">
                                التقارير الطبية ضرورية عند طلب إجازة مرضية. يسمح برفع مستندات (PDF, الصور, فيديو) بحجم لا يتجاوز 10 ميجابايت.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="bg-brand-50/30 p-6 sm:px-8 border-t border-brand-100 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('leave-requests.index') }}" class="px-6 py-3 bg-white border border-brand-200 text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition shadow-sm text-center">
                        العودة وإلغاء الطلب
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-black rounded-xl hover:bg-brand-800 transition shadow-md shadow-brand-950/20 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-base">
                        إرسال الطلب للاعتماد
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
