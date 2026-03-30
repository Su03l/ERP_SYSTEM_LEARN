<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-brand-900">مرحباً بعودتك</h2>
        <p class="text-brand-500 mt-2">سجل دخولك للمتابعة إلى لوحة التحكم</p>
    </div>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-brand-700 mb-1.5">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                placeholder="name@company.com"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-brand-700">كلمة المرور</label>
                <a href="{{ route('password.request') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors">
                    نسيت كلمة المرور؟
                </a>
            </div>
            <x-password-input id="password" name="password" :required="true" class="bg-brand-50 border-brand-200 placeholder-brand-400 focus:ring-brand-950" />
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="w-4 h-4 text-brand-950 bg-brand-50 border-brand-300 rounded focus:ring-brand-500"
            >
            <label for="remember_me" class="mr-2 text-sm text-brand-600">تذكرني</label>
        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="w-full py-3.5 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-950 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]"
        >
            تسجيل الدخول
        </button>
    </form>

</x-guest-layout>
