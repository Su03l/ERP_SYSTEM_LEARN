<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-brand-900">نسيت كلمة المرور؟</h2>
        <p class="text-brand-500 mt-2">لا مشكلة. أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور.</p>
    </div>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
                placeholder="name@company.com"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="w-full py-3.5 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-950 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]"
        >
            إرسال رابط إعادة التعيين
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-brand-500">
        تذكرت كلمة المرور؟
        <a href="{{ route('login') }}" class="font-semibold text-brand-900 hover:underline">العودة لتسجيل الدخول</a>
    </p>
</x-guest-layout>
