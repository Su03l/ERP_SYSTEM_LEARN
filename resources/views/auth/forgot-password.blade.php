<x-guest-layout>
    <div class="text-center py-6">
        <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-brand-400 border border-brand-100">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
        </div>

        <h2 class="text-2xl font-black text-brand-900 mb-3">نسيت كلمة المرور؟</h2>
        <p class="text-sm text-brand-500 leading-relaxed max-w-sm mx-auto mb-8">
            لا يمكن إعادة تعيين كلمة المرور ذاتياً.
            <br>
            يرجى التواصل مع أحد المشرفين أو مسؤول النظام لإعادة تعيين كلمة المرور الخاصة بك.
        </p>

        <div class="bg-brand-50 border border-brand-100 rounded-xl p-5 text-right mb-6">
            <h3 class="text-sm font-bold text-brand-900 mb-2">كيف أتواصل؟</h3>
            <ul class="space-y-2 text-sm text-brand-600 font-medium">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    تواصل مع مشرفك المباشر
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    أو راسل قسم الموارد البشرية عبر البريد الإلكتروني
                </li>
            </ul>
        </div>

        <a href="{{ route('login') }}" class="w-full inline-block py-3.5 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition text-center">
            العودة لتسجيل الدخول
        </a>
    </div>
</x-guest-layout>
