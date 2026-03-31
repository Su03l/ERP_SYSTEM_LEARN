<x-app-layout>
    <x-slot name="header">تعديل بيانات الموظف</x-slot>

    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">

        {{-- ─── HR Instruction Sidebar (1/3 width) ─── --}}
        <div class="lg:w-[350px] shrink-0 order-2 lg:order-1 space-y-6">
            <div class="bg-brand-900 rounded-2xl shadow-sm overflow-hidden text-white">
                <div class="p-6 border-b border-white/10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black tracking-wide mb-1">دليل تحديث السجل</h3>
                    <p class="text-xs text-brand-200 leading-relaxed font-medium">مراجعة وتحديث بيانات الموظف الحالية.</p>
                </div>
                <div class="p-6 bg-brand-950/30 space-y-5">
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">تعديل الصلاحيات:</span> فقط المدير بصلاحيات كاملة يمكنه ترقية أو تخفيض أدوار الموظفين.</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">البيانات المالية:</span> التعديل على الراتب أو الآيبان مقصور على إدارة النظام.</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="mt-0.5 w-1.5 h-1.5 rounded-full bg-brand-400 shrink-0"></div>
                        <p class="text-sm text-brand-100 font-medium leading-relaxed"><span class="font-bold text-white">تحديث الحالة:</span> يمكنك إيقاف حساب الموظف مؤقتاً بتغيير حالته إلى "غير نشط".</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-3 text-brand-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-brand-900 mb-1">صورة الملف الشخصي</h4>
                <p class="text-xs text-brand-500 mb-0 font-medium">يمكن للموظف تعديل صورته الشخصية من خلال إعدادات حسابه الخاص.</p>
            </div>
        </div>

        {{-- ─── Main Form (2/3 width) ─── --}}
        <div class="flex-1 order-1 lg:order-2">
            <form method="POST" action="{{ route('employees.update', $employee) }}" class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
                @csrf
                @method('PUT')

                <div class="bg-brand-50/50 p-6 sm:p-8 border-b border-brand-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-brand-950 rounded-xl flex items-center justify-center text-white text-xl font-bold shadow-inner">
                            @if($employee->avatar ?? false)
                                <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                {{ mb_substr($employee->name, 0, 1) }}
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-brand-950 flex items-center gap-2">
                                {{ $employee->name }}
                            </h2>
                            <p class="text-sm text-brand-500 mt-1 font-medium flex items-center gap-2">
                                تحديث بيانات السجل الوظيفي
                                <x-badge :status="$employee->status ?? 'active'" />
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 space-y-10">
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

                    {{-- Section 1: Personal Info --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-brand-100 pb-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest">المعلومات الشخصية والأساسية</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-bold text-brand-800 mb-2">الاسم الكامل المطابق للهوية <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition"
                                    placeholder="الاسم الرباعي الرسمي">
                            </div>

                            <div>
                                <label for="employee_number" class="block text-sm font-bold text-brand-800 mb-2">رقم الموظف</label>
                                <input type="text" name="employee_number" id="employee_number" value="{{ old('employee_number', $employee->employee_number) }}"
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition"
                                    placeholder="مثال: EMP-001" dir="ltr">
                            </div>

                            <div>
                                <label for="national_id" class="block text-sm font-bold text-brand-800 mb-2">رقم الهوية / الإقامة</label>
                                <input type="text" name="national_id" id="national_id" value="{{ old('national_id', $employee->national_id) }}"
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition"
                                    placeholder="10XXXX أو 20XXXX" dir="ltr" maxlength="20">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-bold text-brand-800 mb-2">البريد الإلكتروني للعمل <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition text-left"
                                    placeholder="user@erp-system.com" dir="ltr">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-bold text-brand-800 mb-2">حالة الموظف</label>
                                <div class="relative">
                                    <select name="status" id="status"
                                        class="w-full pl-10 pr-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition appearance-none">
                                        <option value="active" {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>نشط (يعمل حالياً)</option>
                                        <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>غير نشط (موقوف/مستقيل)</option>
                                    </select>
                                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-bold text-brand-800 mb-2">الجنس</label>
                                <div class="relative">
                                    <select name="gender" id="gender"
                                        class="w-full pl-10 pr-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition appearance-none">
                                        <option value="">-- اضغط للاختيار --</option>
                                        <option value="male" {{ old('gender', $employee->gender) === 'male' ? 'selected' : '' }}>ذكر</option>
                                        <option value="female" {{ old('gender', $employee->gender) === 'female' ? 'selected' : '' }}>أنثى</option>
                                    </select>
                                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <div>
                                <label for="birth_date" class="block text-sm font-bold text-brand-800 mb-2">تاريخ الميلاد</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $employee->birth_date?->format('Y-m-d')) }}"
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition">
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Contact Info --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-brand-100 pb-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest">معلومات الاتصال والطوارئ</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-bold text-brand-800 mb-2">رقم الجوال الخاص</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone) }}"
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition text-left"
                                    placeholder="05XXXXXXXX" dir="ltr">
                            </div>

                            <div>
                                <label for="emergency_contact" class="block text-sm font-bold text-brand-800 mb-2">رقم اتصال للطوارئ</label>
                                <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact', $employee->emergency_contact) }}"
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition text-left"
                                    placeholder="05XXXXXXXX" dir="ltr">
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-bold text-brand-800 mb-2">العنوان الوطني المتواجد به</label>
                                <input type="text" name="address" id="address" value="{{ old('address', $employee->address) }}"
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition"
                                    placeholder="اسم المدينة، الحي، المنطقة، الشارع...">
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Job Details --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-brand-100 pb-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest">الهيكل الوظيفي والصلاحيات</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-brand-50/30 p-5 rounded-2xl border border-brand-100">
                            <div>
                                <label for="job_title" class="block text-sm font-bold text-brand-800 mb-2">المسمى الوظيفي النظامي</label>
                                <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $employee->job_title) }}"
                                    class="w-full px-4 py-3 bg-white border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 transition"
                                    placeholder="مثال: مطور ويب، مهندس مدني">
                            </div>

                            <div>
                                <label for="department" class="block text-sm font-bold text-brand-800 mb-2">اسم القسم / الإدارة</label>
                                <div class="relative">
                                    <select name="department" id="department"
                                        class="w-full pl-10 pr-4 py-3 bg-white border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 transition appearance-none">
                                        <option value="">-- اختر القسم --</option>
                                        @foreach($departments ?? ['الموارد البشرية', 'تقنية المعلومات', 'المبيعات', 'التسويق', 'المالية والمحاسبة', 'العمليات التشغيلية', 'خدمة العملاء', 'المشتريات والمخازن', 'الشؤون القانونية', 'الإدارة العامة'] as $dept)
                                            <option value="{{ $dept }}" {{ old('department', $employee->department) === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <div>
                                <label for="join_date" class="block text-sm font-bold text-brand-800 mb-2">تاريخ الاعتماد الوظيفي</label>
                                <input type="date" name="join_date" id="join_date" value="{{ old('join_date', $employee->join_date?->format('Y-m-d')) }}"
                                    class="w-full px-4 py-3 bg-white border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 transition">
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-bold text-brand-800 mb-2">تحديد الصلاحيات بالمنصة <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="role" id="role" required {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}
                                        class="w-full pl-10 pr-4 py-3 bg-white border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 transition appearance-none {{ auth()->user()->role !== 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}">
                                        <option value="employee" {{ old('role', $employee->role) === 'employee' ? 'selected' : '' }}>صلاحية الموظف الأساسية</option>
                                        @if(auth()->user()->role === 'admin' || $employee->role === 'supervisor')
                                            <option value="supervisor" {{ old('role', $employee->role) === 'supervisor' ? 'selected' : '' }}>صلاحية مشرف</option>
                                        @endif
                                        @if(auth()->user()->role === 'admin' || $employee->role === 'admin')
                                            <option value="admin" {{ old('role', $employee->role) === 'admin' ? 'selected' : '' }}>صلاحية المدير الشاملة</option>
                                        @endif
                                    </select>
                                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                @if(auth()->user()->role !== 'admin')
                                    <input type="hidden" name="role" value="{{ $employee->role }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Section 4: Finance --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 border-b border-brand-100 pb-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-brand-900 uppercase tracking-widest">القوائم المالية والسرية</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-4">
                            <div>
                                <label for="salary" class="block text-sm font-bold text-brand-800 mb-2">استحقاق الراتب الشهري (ر.س)</label>
                                <div class="relative">
                                    <input type="number" name="salary" id="salary" value="{{ old('salary', $employee->salary) }}" step="0.01" min="0" {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}
                                        class="w-full px-4 pr-12 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-bold focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition text-left {{ auth()->user()->role !== 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        placeholder="0.00" dir="ltr">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-brand-400">SAR</span>
                                </div>
                                @if(auth()->user()->role !== 'admin')
                                    <input type="hidden" name="salary" value="{{ $employee->salary }}">
                                @endif
                            </div>

                            <div>
                                <label for="bank_iban" class="block text-sm font-bold text-brand-800 mb-2">تصريح رقم الآيبان (IBAN)</label>
                                <input type="text" name="bank_iban" id="bank_iban" value="{{ old('bank_iban', $employee->bank_iban) }}" {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}
                                    class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-900 focus:bg-white transition text-left {{ auth()->user()->role !== 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    placeholder="SA00 0000 0000 0000 0000 0000" dir="ltr" maxlength="34">
                                @if(auth()->user()->role !== 'admin')
                                    <input type="hidden" name="bank_iban" value="{{ $employee->bank_iban }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="bg-brand-50/30 p-6 sm:px-8 border-t border-brand-100 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4">
                    <a href="{{ route('employees.show', $employee) }}" class="px-6 py-3 bg-white border border-brand-200 text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition shadow-sm text-center">
                        إلغاء والعودة للتفاصيل
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-black rounded-xl hover:bg-brand-800 transition shadow-md shadow-brand-950/20 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-base">
                        حفظ التعديلات
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
