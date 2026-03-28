<x-app-layout>
    <x-slot name="header">طلب إجازة جديد</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in">
            <div class="p-6 border-b border-brand-100">
                <h3 class="text-lg font-bold text-brand-900">تقديم طلب إجازة</h3>
                <p class="text-sm text-brand-500 mt-1">حدد تواريخ الإجازة والسبب وسيتم مراجعة طلبك من قبل الإدارة</p>
            </div>

            <form method="POST" action="{{ route('leave-requests.store') }}" class="p-6 space-y-5">
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
                    <label for="type" class="block text-sm font-semibold text-brand-700 mb-1.5">نوع الإجازة</label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        <option value="">اختر نوع الإجازة</option>
                        <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>إجازة سنوية</option>
                        <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>إجازة مرضية</option>
                        <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>إجازة طارئة</option>
                        <option value="unpaid" {{ old('type') == 'unpaid' ? 'selected' : '' }}>إجازة بدون أجر</option>
                        {{-- Add more options as needed --}}
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-brand-700 mb-1.5">تاريخ البداية</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-brand-700 mb-1.5">تاريخ النهاية</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                            class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label for="reason" class="block text-sm font-semibold text-brand-700 mb-1.5">سبب الإجازة</label>
                    <textarea name="reason" id="reason" rows="4" required
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition resize-none"
                        placeholder="اذكر سبب طلب الإجازة...">{{ old('reason') }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-brand-100">
                    <a href="{{ route('leave-requests.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        ← العودة للقائمة
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        تقديم الطلب
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
