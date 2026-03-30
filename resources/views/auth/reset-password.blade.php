<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-brand-900">إعادة تعيين كلمة المرور</h2>
        <p class="text-brand-500 mt-2">أدخل كلمة المرور الجديدة</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-brand-700 mb-1.5">البريد الإلكتروني</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
                class="w-full px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-brand-900 placeholder-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-950 focus:border-transparent transition"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-brand-700 mb-1.5">كلمة المرور الجديدة</label>
            <x-password-input id="password" name="password" :required="true" class="bg-brand-50 border-brand-200 placeholder-brand-400 focus:ring-brand-950" />
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-brand-700 mb-1.5">تأكيد كلمة المرور</label>
            <x-password-input id="password_confirmation" name="password_confirmation" :required="true" class="bg-brand-50 border-brand-200 placeholder-brand-400 focus:ring-brand-950" />
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="w-full py-3.5 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-950 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]"
        >
            إعادة تعيين كلمة المرور
        </button>
    </form>
</x-guest-layout>
