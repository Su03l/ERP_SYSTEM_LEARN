<x-app-layout>
    <x-slot name="header">الملف الشخصي</x-slot>

    <div class="max-w-6xl mx-auto pb-12 w-full mt-4" x-data="{ 
        tab: '{{ $errors->updatePassword->isNotEmpty() ? 'password' : 'profile' }}',
        showDelete: false,
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
            if(this.$refs.avatarInput) this.$refs.avatarInput.value = '';
        }
    }">
        {{-- Cover Image Hero --}}
        <div class="relative h-48 rounded-2xl bg-gradient-to-r from-brand-900 to-brand-700 overflow-hidden shadow-sm mb-6 animate-fade-in group">
            <div class="absolute inset-0 bg-black/10"></div>
            {{-- Decorative shapes --}}
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-brand-500/20 blur-2xl"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-6 relative z-10 -mt-20 px-4 md:px-0">
            
            {{-- ─── Settings Sidebar ─── --}}
            <div class="w-full md:w-1/3 lg:w-1/4 shrink-0 space-y-4">
                {{-- User Mini Profile Card --}}
                <div class="bg-white/80 backdrop-blur-xl border border-brand-100 rounded-2xl p-5 shadow-lg shadow-brand-900/5 text-center relative pt-14 animate-slide-up">
                    {{-- Avatar --}}
                    <div class="absolute -top-12 left-1/2 -mb-12 min-x-1/2 -ml-12 w-24 h-24 rounded-full border-4 border-white bg-brand-100 shadow-md flex items-center justify-center overflow-hidden z-20">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" id="sidebar-avatar" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=fff&background=020617&size=200" id="sidebar-avatar" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <h2 class="text-lg font-bold text-brand-950 truncate">{{ $user->name }}</h2>
                    <p class="text-sm text-brand-500 truncate mb-4">{{ $user->job_title ?? 'موظف' }}</p>

                    <div class="flex items-center justify-center w-max mx-auto gap-2 text-xs font-semibold text-brand-600 bg-brand-50 px-3 py-1.5 rounded-xl border border-brand-100">
                        <span class="w-2 h-2 rounded-full {{ $user->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $user->status === 'active' ? 'نشط' : 'غير نشط' }}
                    </div>
                </div>

                {{-- Navigation Menu (Desktop) --}}
                <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-2 animate-slide-up stagger-1 hidden md:block">
                    <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-brand-50 text-brand-900 font-bold' : 'text-brand-600 hover:bg-brand-50/50'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition text-right">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        الملف الشخصي
                    </button>
                    <button @click="tab = 'password'" :class="tab === 'password' ? 'bg-brand-50 text-brand-900 font-bold' : 'text-brand-600 hover:bg-brand-50/50'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition text-right mt-1">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        الأمان وكلمة المرور
                    </button>
                    <button @click="tab = 'advanced'" :class="tab === 'advanced' ? 'bg-red-50 text-red-700 font-bold' : 'text-red-500 hover:bg-red-50/50'" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition text-right mt-1">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        إدارة الحساب
                    </button>
                </div>
                
                {{-- Mobile Navigation (Dropdown) --}}
                <div class="md:hidden animate-slide-up stagger-1 mt-10">
                    <select x-model="tab" class="w-full bg-white border border-brand-200 rounded-xl px-4 py-3 text-brand-900 font-semibold focus:ring-2 focus:ring-brand-950 focus:border-transparent outline-none shadow-sm">
                        <option value="profile">الملف الشخصي</option>
                        <option value="password">الأمان وكلمة المرور</option>
                        <option value="advanced">إدارة الحساب</option>
                    </select>
                </div>
            </div>

            {{-- ─── Main Content Area ─── --}}
            <div class="flex-1 w-full bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden animate-slide-up stagger-2 md:mt-24 md:-translate-y-4">
                
                {{-- 1. Profile Tab --}}
                <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="p-6 md:p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-brand-950">المعلومات الأساسية</h3>
                        <p class="text-sm text-brand-500 mt-1">حدّث بيانات حسابك والصورة الشخصية الخاصة بك ليتعرف عليك الزملاء.</p>
                    </div>

                    @if(session('status') === 'profile-updated')
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="font-medium text-sm">تم تحديث الملف الشخصي بنجاح!</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Avatar Upload Area --}}
                        <div class="flex items-center gap-6 p-4 md:p-6 border border-brand-100 rounded-2xl bg-brand-50/50">
                            <input type="hidden" name="delete_avatar" x-model="deleteAvatar">
                            <input type="file" name="avatar" x-ref="avatarInput" class="hidden" @change="previewImage; showAvatarModal = false">
                            
                            <button type="button" @click="showAvatarModal = true" class="relative w-24 h-24 rounded-full border border-brand-200 bg-white overflow-hidden shrink-0 group shadow-sm focus:outline-none focus:ring-4 focus:ring-brand-200 transition-all">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-preview w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=fff&background=020617" class="avatar-preview w-full h-full object-cover">
                                @endif
                                
                                <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none text-white">
                                    <svg class="w-6 h-6 mb-1 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-[10px] font-bold">تعديل</span>
                                </div>
                            </button>

                            <div class="flex-1">
                                <label class="block text-sm font-bold text-brand-900 mb-1">الصورة الشخصية</label>
                                <p class="text-xs text-brand-500 mb-3 hidden md:block">اضغط على الصورة المصغرة لعرضها وإدارتها.</p>
                                <button type="button" @click="showAvatarModal = true" class="px-5 py-2.5 bg-white border border-brand-200 text-brand-700 font-semibold text-sm rounded-xl hover:bg-brand-50 transition drop-shadow-sm flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    إدارة الصورة
                                </button>
                                @error('avatar')
                                    <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-sm font-bold text-brand-900 mb-2">الاسم الكامل</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-brand-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full pr-11 pl-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:border-transparent transition hover:bg-white focus:bg-white shadow-sm">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-bold text-brand-900 mb-2">البريد الإلكتروني</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-brand-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    </div>
                                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full pr-11 pl-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:border-transparent transition hover:bg-white focus:bg-white shadow-sm" dir="ltr" style="text-align: right;">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-brand-100 flex justify-end">
                            <button type="submit" class="px-8 py-3 w-full md:w-auto bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition shadow-lg shadow-brand-950/20 transform hover:-translate-y-0.5 active:translate-y-0">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>

                    {{-- Avatar Viewing/Management Modal --}}
                    <div x-show="showAvatarModal" x-transition.opacity class="fixed inset-0 min-h-screen bg-brand-950/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
                        <div @click.outside="showAvatarModal = false" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white rounded-3xl w-full max-w-sm p-6 shadow-2xl relative border border-brand-100">
                            {{-- Close Button --}}
                            <button type="button" @click="showAvatarModal = false" class="absolute top-4 left-4 w-8 h-8 flex items-center justify-center text-brand-400 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 rounded-full transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            <h3 class="text-lg font-bold text-center text-brand-900 mb-6">الصورة الشخصية</h3>

                            <div class="flex justify-center mb-8">
                                <div class="w-48 h-48 rounded-full border-4 border-brand-50 shadow-xl overflow-hidden relative group">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-preview w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=fff&background=020617" class="avatar-preview w-full h-full object-cover">
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" @click="$refs.avatarInput.click()" class="flex flex-col items-center justify-center gap-2 p-3 bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold rounded-2xl transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"></path></svg>
                                    <span class="text-sm">تغيير الصورة</span>
                                </button>
                                <button type="button" @click="removeAvatar" class="flex flex-col items-center justify-center gap-2 p-3 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-2xl transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                    <span class="text-sm">حذف الصورة</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Password Tab --}}
                <div x-show="tab === 'password'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="p-6 md:p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-brand-950">الأمان وكلمة المرور</h3>
                        <p class="text-sm text-brand-500 mt-1">احرص على استخدام كلمة مرور قوية وفريدة لحماية حسابك من الاختراق.</p>
                    </div>

                    @if(session('status') === 'password-updated')
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="font-medium text-sm">تم تحديث كلمة المرور بنجاح!</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6 max-w-2xl">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-bold text-brand-900 mb-2">كلمة المرور الحالية</label>
                            <input id="current_password" type="password" name="current_password" class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:border-transparent transition hover:bg-white focus:bg-white shadow-sm" placeholder="••••••••" dir="ltr">
                            @error('current_password', 'updatePassword')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-brand-900 mb-2">كلمة المرور الجديدة</label>
                            <input id="password" type="password" name="password" class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:border-transparent transition hover:bg-white focus:bg-white shadow-sm" placeholder="••••••••" dir="ltr">
                            @error('password', 'updatePassword')
                                <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-brand-900 mb-2">تأكيد كلمة المرور الجديدة</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="w-full px-4 py-3 bg-brand-50/50 border border-brand-200 rounded-xl text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 focus:border-transparent transition hover:bg-white focus:bg-white shadow-sm" placeholder="••••••••" dir="ltr">
                        </div>

                        <div class="pt-6 border-t border-brand-100 flex justify-end">
                            <button type="submit" class="px-8 py-3 w-full md:w-auto bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition shadow-lg shadow-brand-950/20 transform hover:-translate-y-0.5 active:translate-y-0">
                                تحديث كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 3. Danger Zone Tab --}}
                <div x-show="tab === 'advanced'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="p-6 md:p-8">
                    <div class="p-6 bg-red-50 border border-red-100 rounded-2xl flex flex-col md:flex-row items-start gap-4">
                        <div class="flex-shrink-0 p-3 bg-red-100 rounded-full text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-red-700">حذف الحساب نهائياً</h3>
                            <p class="text-sm text-red-500/80 mt-1 leading-relaxed">تحذير: بمجرد حذف حسابك، سيتم مسح جميع بياناتك وسجلاتك نهائياً من النظام ولا يمكن التراجع عن هذه الخطوة.</p>
                            <button @click="showDelete = true" class="mt-4 px-6 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-600/20 flex items-center justify-center md:justify-start gap-2 w-full md:w-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                المتابعة لحذف الحساب
                            </button>
                        </div>
                    </div>

                    {{-- Delete Modal --}}
                    <div x-show="showDelete" x-transition.opacity class="fixed inset-0 min-h-screen bg-brand-950/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
                        <div @click.outside="showDelete = false" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-2xl relative border border-brand-100">
                            {{-- Close Button --}}
                            <button @click="showDelete = false" class="absolute top-4 left-4 p-2 text-brand-400 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 rounded-full transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            <div class="mx-auto w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            
                            <h4 class="text-2xl font-black text-brand-950 mb-2 text-center">أنت على وشك حذف حسابك!</h4>
                            <p class="text-sm text-brand-500 mb-8 text-center leading-relaxed">
                                يرجى إدخال كلمة المرور لتأكيد رغبتك بالقيام بهذه الخطوة، 
                                علماً أنه لا يمكن استعادة أي من التذاكر أو الإجازات أو البيانات المرتبطة بك بعد الحذف.
                            </p>
                            
                            <form method="POST" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('DELETE')
                                <div class="mb-6">
                                    <input type="password" name="password" placeholder="أدخل كلمة المرور للتأكيد" class="w-full px-5 py-4 bg-brand-50/50 border border-brand-200 rounded-xl text-center font-bold text-brand-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition shadow-inner" required autofocus dir="ltr">
                                    @error('password', 'userDeletion')
                                        <p class="mt-2 text-sm font-semibold text-red-600 text-center">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex flex-col md:flex-row gap-4">
                                    <button type="submit" class="flex-1 px-6 py-3.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-bold shadow-lg shadow-red-600/20">
                                        تأكيد الحذف النهائي
                                    </button>
                                    <button type="button" @click="showDelete = false" class="flex-1 px-6 py-3.5 bg-white border border-brand-200 text-brand-700 rounded-xl hover:bg-brand-50 transition font-bold">
                                        إلغاء الأمر
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
