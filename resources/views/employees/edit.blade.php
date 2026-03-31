<x-app-layout>
    <x-slot name="header">تعديل بيانات الموظف</x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in">
            <div class="p-6 border-b border-brand-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-brand-950 rounded-xl flex items-center justify-center text-white font-bold">
                        {{ mb_substr($employee->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-brand-900">{{ $employee->name }}</h3>
                        <p class="text-sm text-brand-500">تعديل بيانات الموظف</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('employees.update', $employee) }}" class="p-6 space-y-8">
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

                {{-- ─── القسم 1: المعلومات الأساسية ─── --}}
                <div>
                    <h4 class="text-sm font-bold text-brand-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-brand-950 text-white rounded-md flex items-center justify-center text-xs">1</span>
                        المعلومات الأساسية
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-brand-700 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="employee_number" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الموظف</label>
                            <input type="text" name="employee_number" id="employee_number" value="{{ old('employee_number', $employee->employee_number) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition" dir="ltr"
                                placeholder="مثال: EMP-001">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-brand-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الجوال</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition" dir="ltr">
                        </div>

                        <div>
                            <label for="national_id" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الهوية</label>
                            <input type="text" name="national_id" id="national_id" value="{{ old('national_id', $employee->national_id) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition" dir="ltr" maxlength="20">
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-semibold text-brand-700 mb-1.5">الجنس</label>
                            <select name="gender" id="gender"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                                <option value="">— اختر —</option>
                                <option value="male" {{ old('gender', $employee->gender) === 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender', $employee->gender) === 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                        </div>

                        <div>
                            <label for="birth_date" class="block text-sm font-semibold text-brand-700 mb-1.5">تاريخ الميلاد</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $employee->birth_date?->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-brand-700 mb-1.5">العنوان</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $employee->address) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-brand-700 mb-1.5">الحالة</label>
                            <select name="status" id="status"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                                <option value="active" {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
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
                            <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $employee->job_title) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-semibold text-brand-700 mb-1.5">الصلاحية (الدور) <span class="text-red-500">*</span></label>
                            <select name="role" id="role" required {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition {{ auth()->user()->role !== 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}">
                                <option value="employee" {{ old('role', $employee->role) === 'employee' ? 'selected' : '' }}>موظف</option>
                                @if(auth()->user()->role === 'admin' || $employee->role === 'supervisor')
                                    <option value="supervisor" {{ old('role', $employee->role) === 'supervisor' ? 'selected' : '' }}>مشرف</option>
                                @endif
                                @if(auth()->user()->role === 'admin' || $employee->role === 'admin')
                                    <option value="admin" {{ old('role', $employee->role) === 'admin' ? 'selected' : '' }}>مدير (أدمن)</option>
                                @endif
                            </select>
                            @if(auth()->user()->role !== 'admin')
                                <input type="hidden" name="role" value="{{ $employee->role }}">
                            @endif
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-semibold text-brand-700 mb-1.5">القسم</label>
                            <select name="department" id="department"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                                <option value="">-- اختر القسم --</option>
                                <option value="الموارد البشرية" {{ old('department', $employee->department) === 'الموارد البشرية' ? 'selected' : '' }}>الموارد البشرية (Human Resources)</option>
                                <option value="تقنية المعلومات" {{ old('department', $employee->department) === 'تقنية المعلومات' ? 'selected' : '' }}>تقنية المعلومات (Information Technology)</option>
                                <option value="المبيعات" {{ old('department', $employee->department) === 'المبيعات' ? 'selected' : '' }}>المبيعات (Sales)</option>
                                <option value="التسويق" {{ old('department', $employee->department) === 'التسويق' ? 'selected' : '' }}>التسويق (Marketing)</option>
                                <option value="المالية والمحاسبة" {{ old('department', $employee->department) === 'المالية والمحاسبة' ? 'selected' : '' }}>المالية والمحاسبة (Finance & Accounting)</option>
                                <option value="العمليات التشغيلية" {{ old('department', $employee->department) === 'العمليات التشغيلية' ? 'selected' : '' }}>العمليات التشغيلية (Operations)</option>
                                <option value="خدمة العملاء" {{ old('department', $employee->department) === 'خدمة العملاء' ? 'selected' : '' }}>خدمة العملاء (Customer Service)</option>
                                <option value="المشتريات والمخازن" {{ old('department', $employee->department) === 'المشتريات والمخازن' ? 'selected' : '' }}>المشتريات والمخازن (Procurement & Logistics)</option>
                                <option value="الشؤون القانونية" {{ old('department', $employee->department) === 'الشؤون القانونية' ? 'selected' : '' }}>الشؤون القانونية (Legal)</option>
                                <option value="الإدارة العامة" {{ old('department', $employee->department) === 'الإدارة العامة' ? 'selected' : '' }}>الإدارة العامة (General Management)</option>
                            </select>
                        </div>

                        <div>
                            <label for="join_date" class="block text-sm font-semibold text-brand-700 mb-1.5">تاريخ الالتحاق</label>
                            <input type="date" name="join_date" id="join_date" value="{{ old('join_date', $employee->join_date?->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="emergency_contact" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الطوارئ</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact', $employee->emergency_contact) }}"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition" dir="ltr">
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
                            <input type="number" name="salary" id="salary" value="{{ old('salary', $employee->salary) }}" step="0.01" min="0" {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition {{ auth()->user()->role !== 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}" dir="ltr">
                            @if(auth()->user()->role !== 'admin')
                                <input type="hidden" name="salary" value="{{ $employee->salary }}">
                            @endif
                        </div>

                        <div>
                            <label for="bank_iban" class="block text-sm font-semibold text-brand-700 mb-1.5">رقم الآيبان (IBAN)</label>
                            <input type="text" name="bank_iban" id="bank_iban" value="{{ old('bank_iban', $employee->bank_iban) }}" {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition {{ auth()->user()->role !== 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}" dir="ltr" maxlength="34">
                            @if(auth()->user()->role !== 'admin')
                                <input type="hidden" name="bank_iban" value="{{ $employee->bank_iban }}">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-brand-100">
                    <a href="{{ route('employees.show', $employee) }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        ← العودة للتفاصيل
                    </a>
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
