<x-app-layout>
    <x-slot name="header">تقديم تذكرة دعم فني جديدة</x-slot>

    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
        
        {{-- ─── Instruction Sidebar (1/3 width) ─── --}}
        <div class="lg:w-[350px] shrink-0 order-2 lg:order-1 space-y-6">
            <div class="bg-brand-900 rounded-2xl shadow-sm overflow-hidden text-white">
                <div class="p-6 border-b border-white/10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black tracking-wide mb-1">كيف تكتب تذكرة جيدة؟</h3>
                    <p class="text-xs text-brand-200 leading-relaxed font-medium">اتباعك لهذه الإرشادات يسرّع من عملية حل المشكلة الخاصة بك بشكل كبير.</p>
                </div>
                <div class="p-6 bg-brand-950/30 space-y-5">
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">العنوان الواضح:</span> استخدم عنواناً يختصر المشكلة، مثل "عدم ظهور رصيد الإجازات" بدلاً من "عندي مشكلة".</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">التفاصيل الكاملة:</span> اشرح في صندوق الوصف ما كنت تقوم به عندما واجهت الخطأ خطوة بخطوة.</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">إرفاق لقطة شاشة:</span> يُفضل جداً إرفاق صورة للصفحة أو رسالة الخطأ لتسهيل فهم الخلل فوراً.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-3 text-brand-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-brand-900 mb-1">وقت الاستجابة المتوقع</h4>
                <p class="text-xs text-brand-500 mb-0 font-medium">يقوم فريق الدعم الفني بالرد على التذاكر الجديدة خلال مدة أقصاها 24 ساعة عمل.</p>
            </div>
        </div>

        {{-- ─── Main Form (2/3 width) ─── --}}
        <div class="flex-1 order-1 lg:order-2">
            <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
                @csrf
                
                <div class="bg-brand-50/50 p-6 sm:p-8 border-b border-brand-100">
                    <h2 class="text-xl font-black text-brand-950 flex items-center gap-2">
                        نموذج الدعم الفني
                    </h2>
                    <p class="text-sm text-brand-500 mt-2 font-medium">صف طلبك أو المشكلة التي تمر بها وسيعمل خبراؤنا على مساعدتك.</p>
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

                    {{-- Ticket Content Section --}}
                    <div class="space-y-6">
                        <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest border-b border-brand-100 pb-2">التفاصيل الفنية</h4>
                        
                        <div>
                            <label for="subject" class="block text-sm font-bold text-brand-800 mb-2">عنوان المشكلة أو الطلب</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                class="w-full px-4 py-3.5 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition"
                                placeholder="مثال: خطأ عند محاولة طباعة التقرير الشهري">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-brand-800 mb-2">الشرح الوافي</label>
                            <textarea name="description" id="description" rows="7" required
                                class="w-full px-4 py-4 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium placeholder-brand-300 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition resize-none leading-relaxed"
                                placeholder="اكتب كل التفاصيل التي ستساعدنا على فهم وحل المشكلة بشكل أسرع...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    {{-- Attachment Section --}}
                    <div class="space-y-6 pt-2">
                        <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest border-b border-brand-100 pb-2">لقطات الشاشة والملفات</h4>
                        
                        <div class="bg-brand-50/50 rounded-xl border border-brand-200 border-dashed p-6">
                            <label for="attachment" class="block text-sm font-bold text-brand-800 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                رفع ملف توضيحي (اختياري)
                            </label>
                            <input type="file" name="attachment" id="attachment"
                                class="w-full px-4 py-3 bg-white border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 transition file:mr-4 file:py-2 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-900 file:text-white hover:file:bg-brand-800 cursor-pointer shadow-sm">
                            <p class="text-xs text-brand-500 font-medium mt-3 leading-relaxed">
                                يمكنك تصوير الشاشة (Screenshot) وتصديرها، أو رفع مقطع فيديو قصير للمشكلة بحجم أقصاه 20 ميجابايت.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="bg-brand-50/30 p-6 sm:px-8 border-t border-brand-100 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('tickets.index') }}" class="px-6 py-3 bg-white border border-brand-200 text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition shadow-sm text-center">
                        العودة لقائمة التذاكر
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-black rounded-xl hover:bg-brand-800 transition shadow-md shadow-brand-950/20 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-base">
                        تسليم التذكرة
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4p7 7-7 7m0-14l7 7-7 7"></path></svg>
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
