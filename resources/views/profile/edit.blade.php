<x-app-layout>
    <x-slot name="header">
        <span class="font-black tracking-tight">إعدادات الحساب</span>
    </x-slot>

    <div class="max-w-7xl mx-auto pb-12 w-full mt-8 px-4 sm:px-6 lg:px-8" x-data="{
        tab: '{{ $errors->updatePassword->isNotEmpty() ? 'password' : 'profile' }}',
        showAvatarModal: false,
        deleteAvatar: '0',
        previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.querySelectorAll('.avatar-preview').forEach(img => img.src = e.target.result);
                    this.deleteAvatar = '0';
                }
                reader.readAsDataURL(input.files[0]);
            }
        },
        removeAvatar() {
            this.deleteAvatar = '1';
            const defaultAvatar = 'https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=fff&background=020617&size=200';
            document.querySelectorAll('.avatar-preview').forEach(img => img.src = defaultAvatar);
            this.showAvatarModal = false;
        }
    }">

        {{-- ─── Header Hero Section (Enhanced) ─── --}}
        <div
            class="relative h-52 rounded-[2.5rem] bg-gradient-to-br from-brand-950 via-brand-900 to-brand-800 overflow-hidden shadow-2xl mb-10 group">
            {{-- Decorative Elements --}}
            <div
                class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
            </div>
            <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-brand-500/20 blur-[100px] animate-pulse">
            </div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-blue-500/10 blur-[80px]"></div>

            <div class="relative z-10 h-full flex flex-col justify-center px-12">
                <nav class="flex mb-4 text-brand-300 text-xs font-bold uppercase tracking-widest"
                    aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-reverse space-x-2">
                        <li>الرئيسية</li>
                        <li>
                            <svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" />
                            </svg>
                        </li>
                        <li class="text-white">إعدادات الحساب</li>
                    </ol>
                </nav>
                <h1 class="text-4xl font-black text-white tracking-tighter shadow-sm">الملف الشخصي</h1>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">

            {{-- ─── Left Column: Identity Card ─── --}}
            <aside class="w-full lg:w-1/3 space-y-8">
                <div
                    class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-brand-100 shadow-xl shadow-brand-900/5 overflow-hidden p-8 relative">
                    {{-- Avatar Section --}}
                    <div class="relative w-40 h-40 mx-auto mb-6 group">
                        <div
                            class="w-full h-full rounded-full border-[6px] border-white shadow-2xl bg-brand-50 overflow-hidden transition-transform duration-500 group-hover:scale-105">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=fff&background=020617&size=200' }}"
                                class="avatar-preview w-full h-full object-cover">
                        </div>
                        <button @click="showAvatarModal = true" type="button"
                            class="absolute bottom-1 right-1 p-3 bg-brand-900 text-white rounded-2xl shadow-lg hover:bg-brand-800 transition-all duration-300 transform hover:rotate-12 focus:ring-4 focus:ring-brand-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9zM15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-black text-brand-950 tracking-tight capitalize">{{ $user->name }}
                        </h2>
                        <div
                            class="inline-flex items-center mt-2 px-3 py-1 bg-brand-50 rounded-full border border-brand-100">
                            <span
                                class="text-xs font-bold text-brand-600">{{ $user->job_title ?? 'مهندس برمجيات' }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-6 border-t border-brand-50">
                        <button @click="tab = 'profile'" type="button"
                            :class="tab === 'profile' ? 'bg-brand-900 text-white shadow-lg shadow-brand-900/20 translate-x-1' :
                                'text-brand-600 hover:bg-brand-50'"
                            class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 font-black text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            المعلومات الأساسية
                        </button>
                        <button @click="tab = 'password'" type="button"
                            :class="tab === 'password' ? 'bg-brand-900 text-white shadow-lg shadow-brand-900/20 translate-x-1' :
                                'text-brand-600 hover:bg-brand-50'"
                            class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 font-black text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            الأمان وكلمة المرور
                        </button>
                    </div>
                </div>

                {{-- Status Card --}}
                <div
                    class="bg-gradient-to-br from-white to-brand-50 rounded-[2.5rem] p-1 border border-brand-100 shadow-sm">
                    <div class="bg-white rounded-[2.3rem] p-6 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-brand-400 uppercase tracking-tighter">حالة الحساب</p>
                            <p class="text-sm font-black text-brand-900">نشط في النظام</p>
                        </div>
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-500 border border-green-100">
                            <span class="relative flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- ─── Right Column: Content Area ─── --}}
            <main class="flex-1">
                <div
                    class="bg-white rounded-[2.5rem] border border-brand-100 shadow-xl shadow-brand-900/5 overflow-hidden min-h-[650px]">

                    {{-- Profile Form --}}
                    <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0" class="p-10">

                        <div class="mb-12">
                            <h3 class="text-2xl font-black text-brand-950 tracking-tight">المعلومات الشخصية</h3>
                            <div class="w-12 h-1.5 bg-brand-900 rounded-full mt-3"></div>
                        </div>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                            class="space-y-10">
                            @csrf @method('PATCH')
                            <input type="hidden" name="delete_avatar" x-model="deleteAvatar">
                            <input type="file" name="avatar" x-ref="avatarInput" class="hidden"
                                @change="previewImage; showAvatarModal = false">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="md:col-span-2 group">
                                    <label
                                        class="text-xs font-black text-brand-900 mb-3 block px-1 uppercase tracking-widest">الاسم
                                        الكامل</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        class="w-full bg-brand-50/20 border border-brand-200 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-brand-900/5 focus:border-brand-900 transition-all duration-300 shadow-sm">
                                </div>

                                <div>
                                    <label
                                        class="text-xs font-black text-brand-900 mb-3 block px-1 uppercase tracking-widest">البريد
                                        الإلكتروني</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full bg-brand-50/20 border border-brand-200 rounded-2xl py-4 px-6 text-left font-mono focus:ring-4 focus:ring-brand-900/5 transition-all shadow-sm"
                                        dir="ltr">
                                </div>

                                <div>
                                    <label
                                        class="text-xs font-black text-brand-900 mb-3 block px-1 uppercase tracking-widest">رقم
                                        الجوال</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="w-full bg-brand-50/20 border border-brand-200 rounded-2xl py-4 px-6 text-left focus:ring-4 focus:ring-brand-900/5 transition-all shadow-sm"
                                        dir="ltr" placeholder="05xxxxxxxx">
                                </div>

                                {{-- Section: Financial --}}
                                <div
                                    class="md:col-span-2 mt-4 p-8 bg-brand-50/30 rounded-[2rem] border border-brand-100/50 relative overflow-hidden">
                                    <div
                                        class="absolute top-0 right-0 w-24 h-24 bg-brand-900/5 rounded-full -mr-12 -mt-12">
                                    </div>
                                    <h4
                                        class="text-sm font-black text-brand-950 mb-6 flex items-center gap-2 uppercase tracking-widest">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        البيانات المالية والوطنية
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                                        <div class="md:col-span-1">
                                            <label class="text-[10px] font-black text-brand-400 mb-2 block px-1">رقم
                                                الهوية</label>
                                            <input type="text" name="national_id"
                                                value="{{ old('national_id', $user->national_id) }}"
                                                class="w-full border border-brand-200 rounded-xl py-3.5 px-5 bg-white shadow-sm focus:border-brand-900 focus:ring-0 transition-all">
                                        </div>
                                        <div class="md:col-span-1">
                                            <label class="text-[10px] font-black text-brand-400 mb-2 block px-1">رقم
                                                الآيبان (IBAN)</label>
                                            <input type="text" name="bank_iban"
                                                value="{{ old('bank_iban', $user->bank_iban) }}"
                                                class="w-full border border-brand-200 rounded-xl py-3.5 px-5 bg-white shadow-sm font-mono text-xs focus:border-brand-900 focus:ring-0 transition-all"
                                                dir="ltr">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-8">
                                <button type="submit"
                                    class="group relative inline-flex items-center justify-center px-12 py-4 font-black text-white transition-all duration-300 bg-brand-950 rounded-2xl hover:bg-brand-900 shadow-xl shadow-brand-900/30 overflow-hidden">
                                    <span class="relative z-10">حفظ التغييرات</span>
                                    <div
                                        class="absolute inset-0 w-full h-full bg-gradient-to-r from-brand-900 to-brand-800 opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Password Form --}}
                    <div x-show="tab === 'password'" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="p-10">

                        <div class="mb-12">
                            <h3 class="text-2xl font-black text-brand-950 tracking-tight">تحديث الأمان</h3>
                            <div class="w-12 h-1.5 bg-brand-900 rounded-full mt-3"></div>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}" class="max-w-xl space-y-8">
                            @csrf @method('PUT')
                            <div class="space-y-6">
                                <div class="group">
                                    <label
                                        class="text-xs font-black text-brand-900 mb-3 block uppercase tracking-widest">كلمة
                                        المرور الحالية</label>
                                    <x-password-input name="current_password"
                                        class="w-full rounded-2xl border border-brand-200 !bg-brand-50/20" />
                                </div>
                                <div class="group">
                                    <label
                                        class="text-xs font-black text-brand-900 mb-3 block uppercase tracking-widest">كلمة
                                        المرور الجديدة</label>
                                    <x-password-input name="password"
                                        class="w-full rounded-2xl border border-brand-200 !bg-brand-50/20" />
                                </div>
                            </div>

                            <div class="flex justify-end pt-8">
                                <button type="submit"
                                    class="w-full md:w-auto bg-brand-950 text-white px-12 py-4 rounded-2xl font-black shadow-xl shadow-brand-900/20 hover:scale-[1.02] transition-transform active:scale-[0.98]">
                                    تحديث كلمة المرور
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>

        {{-- Avatar Modal (Enhanced UI) - NOW INSIDE x-data --}}
        <div x-show="showAvatarModal" x-transition.opacity
            class="fixed inset-0 bg-brand-950/90 backdrop-blur-xl z-[100] flex items-center justify-center p-4"
            style="display: none;">
            <div @click.outside="showAvatarModal = false"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="scale-90 opacity-0" x-transition:enter-end="scale-100 opacity-100"
                class="bg-white rounded-[3rem] max-w-sm w-full p-10 shadow-2xl relative border border-white/20">

                <h3 class="text-xl font-black text-center text-brand-950 mb-10 tracking-tight uppercase">الصورة الشخصية
                </h3>

                <div
                    class="w-56 h-56 rounded-full overflow-hidden mx-auto mb-10 border-8 border-brand-50 shadow-2xl relative">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=fff&background=020617' }}"
                        class="avatar-preview w-full h-full object-cover">
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <button type="button" @click="$refs.avatarInput.click()"
                        class="group flex items-center justify-center gap-3 py-4 bg-brand-950 text-white font-black rounded-2xl hover:bg-brand-800 transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        تغيير الصورة
                    </button>
                    <button type="button" @click="removeAvatar"
                        class="flex items-center justify-center gap-3 py-4 bg-red-50 text-red-600 font-black rounded-2xl hover:bg-red-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        حذف الصورة
                    </button>
                </div>

                <button type="button" @click="showAvatarModal = false"
                    class="mt-6 w-full text-brand-400 text-xs font-bold hover:text-brand-900 transition-colors uppercase tracking-widest">
                    إغلاق
                </button>
            </div>
        </div>

    </div>
</x-app-layout>
