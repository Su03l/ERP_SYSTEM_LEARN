<x-app-layout>
    <x-slot name="header">الملف الشخصي</x-slot>

    <div class="max-w-3xl space-y-6">
        {{-- Profile Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in">
            <div class="p-6 border-b border-brand-50">
                <h3 class="text-lg font-bold text-brand-900">معلومات الحساب</h3>
                <p class="text-sm text-brand-500 mt-1">حدّث بيانات حسابك والبريد الإلكتروني</p>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-semibold text-brand-700 mb-1.5">الاسم</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-brand-700 mb-1.5">البريد الإلكتروني</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        حفظ التغييرات
                    </button>
                </div>

                @if(session('status') === 'profile-updated')
                    <div class="text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
                        تم تحديث الملف الشخصي بنجاح
                    </div>
                @endif
            </form>
        </div>

        {{-- Change Password --}}
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in stagger-1">
            <div class="p-6 border-b border-brand-50">
                <h3 class="text-lg font-bold text-brand-900">تغيير كلمة المرور</h3>
                <p class="text-sm text-brand-500 mt-1">تأكد من استخدام كلمة مرور قوية وفريدة</p>
            </div>
            <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-semibold text-brand-700 mb-1.5">كلمة المرور الحالية</label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                    @error('current_password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-brand-700 mb-1.5">كلمة المرور الجديدة</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                    @error('password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-brand-700 mb-1.5">تأكيد كلمة المرور</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                        تحديث كلمة المرور
                    </button>
                </div>
            </form>
        </div>

        {{-- Delete Account --}}
        <div x-data="{ showDelete: false }" class="bg-white rounded-2xl shadow-sm border border-red-100 animate-fade-in stagger-2">
            <div class="p-6 border-b border-red-50">
                <h3 class="text-lg font-bold text-red-700">حذف الحساب</h3>
                <p class="text-sm text-brand-500 mt-1">بمجرد حذف حسابك، سيتم حذف جميع بياناتك نهائياً</p>
            </div>
            <div class="p-6">
                <button @click="showDelete = true" class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all duration-200">
                    حذف الحساب
                </button>

                {{-- Delete Modal --}}
                <div x-show="showDelete" x-transition.opacity class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display: none;">
                    <div @click.outside="showDelete = false" x-transition class="bg-white rounded-2xl w-full max-w-md p-6 animate-scale-in">
                        <h4 class="text-lg font-bold text-brand-900 mb-2">هل أنت متأكد؟</h4>
                        <p class="text-sm text-brand-500 mb-6">أدخل كلمة المرور لتأكيد حذف حسابك نهائياً.</p>
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <input
                                type="password"
                                name="password"
                                placeholder="كلمة المرور"
                                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition mb-4"
                                required
                            >
                            <div class="flex gap-3 justify-end">
                                <button type="button" @click="showDelete = false" class="px-6 py-2.5 border border-brand-200 text-brand-700 rounded-xl hover:bg-brand-50 transition font-medium">
                                    إلغاء
                                </button>
                                <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-bold">
                                    حذف نهائياً
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
