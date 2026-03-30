<x-app-layout>
    <x-slot name="header">تذكرة جديدة</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in">
            <div class="p-6 border-b border-brand-100">
                <h3 class="text-lg font-bold text-brand-900">إنشاء تذكرة دعم</h3>
                <p class="text-sm text-brand-500 mt-1">صف مشكلتك أو طلبك بالتفصيل وسنعمل على حلها</p>
            </div>

            <form method="POST" action="{{ route('tickets.store') }}" class="p-6 space-y-5" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="subject" class="block text-sm font-semibold text-brand-700 mb-1.5">الموضوع</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                        placeholder="عنوان مختصر للمشكلة">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-brand-700 mb-1.5">الوصف</label>
                    <textarea name="description" id="description" rows="6" required
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition resize-none"
                        placeholder="اشرح المشكلة أو الطلب بالتفصيل...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="attachment" class="block text-sm font-semibold text-brand-700 mb-1.5">إرفاق ملف (اختياري)</label>
                    <input type="file" name="attachment" id="attachment"
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 transition file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-950 file:text-white hover:file:bg-brand-800 cursor-pointer text-sm">
                    <p class="text-xs font-medium text-brand-500 mt-2">يمكنك رفع صور، ملفات PDF، مستندات Word، أو فيديو توضيحي (بحد أقصى 20 ميجابايت).</p>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-brand-100">
                    <a href="{{ route('tickets.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        ← العودة للقائمة
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        إرسال التذكرة
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
