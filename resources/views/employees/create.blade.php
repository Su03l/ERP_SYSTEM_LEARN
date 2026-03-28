<x-app-layout>
    <x-slot name="header">إضافة موظف جديد</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in">
            <div class="p-6 border-b border-brand-100">
                <h3 class="text-lg font-bold text-brand-900">بيانات الموظف</h3>
                <p class="text-sm text-brand-500 mt-1">أدخل بيانات الموظف الجديد. سيتم إنشاء كلمة مرور افتراضية.</p>
            </div>

            <form method="POST" action="{{ route('employees.store') }}" class="p-6 space-y-8">
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

                {{-- ─── القسم 1: المعلومات الأساسية ─── --}}
                <div>
                    <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-brand-950 text-white rounded-md flex items-center justify-center text-xs">1</span>
                        المعلومات الأساسية
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-brand-700 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="أدخل اسم الموظف الكامل">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-brand-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="name@company.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-brand-700 mb-1.5">كلمة المرور <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required minlength="8"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="8 أحرف على الأقل">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-brand-700 mb-1.5">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="أعد إدخال كلمة المرور">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الجوال</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="05XXXXXXXX" dir="ltr">
                        </div>

                        <div>
                            <label for="national_id" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الهوية</label>
                            <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="1XXXXXXXXX" dir="ltr" maxlength="20">
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-semibold text-brand-700 mb-1.5">الجنس</label>
                            <select name="gender" id="gender"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                                <option value="">— اختر —</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                        </div>

                        <div>
                            <label for="birth_date" class="block text-sm font-semibold text-brand-700 mb-1.5">تاريخ الميلاد</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-brand-700 mb-1.5">العنوان</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="المدينة، الحي، الشارع">
                        </div>
                    </div>
                </div>

                <div class="border-t border-brand-100"></div>

                {{-- ─── القسم 2: المعلومات الوظيفية ─── --}}
                <div>
                    <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-brand-950 text-white rounded-md flex items-center justify-center text-xs">2</span>
                        المعلومات الوظيفية
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="job_title" class="block text-sm font-semibold text-brand-700 mb-1.5">المسمى الوظيفي</label>
                            <input type="text" name="job_title" id="job_title" value="{{ old('job_title') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="مثلاً: مطور ويب">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-semibold text-brand-700 mb-1.5">الصلاحية (الدور) <span class="text-red-500">*</span></label>
                            <select name="role" id="role" required
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                                <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>موظف</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>مدير (أدمن)</option>
                            </select>
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-semibold text-brand-700 mb-1.5">القسم</label>
                            <input type="text" name="department" id="department" value="{{ old('department') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="مثلاً: تقنية المعلومات">
                        </div>

                        <div>
                            <label for="join_date" class="block text-sm font-semibold text-brand-700 mb-1.5">تاريخ الالتحاق</label>
                            <input type="date" name="join_date" id="join_date" value="{{ old('join_date') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="emergency_contact" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الطوارئ</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="05XXXXXXXX" dir="ltr">
                        </div>
                    </div>
                </div>

                <div class="border-t border-brand-100"></div>

                {{-- ─── القسم 3: المعلومات المالية ─── --}}
                <div>
                    <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-brand-950 text-white rounded-md flex items-center justify-center text-xs">3</span>
                        المعلومات المالية
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="salary" class="block text-sm font-semibold text-brand-700 mb-1.5">الراتب الشهري (ر.س)</label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary') }}" step="0.01" min="0"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="0.00" dir="ltr">
                        </div>

                        <div>
                            <label for="bank_iban" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الآيبان (IBAN)</label>
                            <input type="text" name="bank_iban" id="bank_iban" value="{{ old('bank_iban') }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                                placeholder="SA0000000000000000000000" dir="ltr" maxlength="34">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-brand-100">
                    <a href="{{ route('employees.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        ← العودة للقائمة
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        حفظ الموظف
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
