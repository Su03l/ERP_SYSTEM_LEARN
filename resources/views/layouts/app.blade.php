<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::id() }}">
    <meta name="user-role" content="{{ Auth::user()->role }}">
    <title>{{ config('app.name', 'ERP System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-brand-50 text-brand-900">
    <div x-data="{ sidebarOpen: true, mobileOpen: false }" class="min-h-screen flex">

        {{-- ─── Sidebar ─── --}}
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="hidden lg:flex flex-col fixed inset-y-0 right-0 bg-gradient-to-b from-brand-950 to-brand-900 border-l border-white/5 text-white transition-all duration-300 z-30 shadow-2xl"
        >
            {{-- Logo --}}
            <div class="h-16 flex items-center justify-center border-b border-brand-800 shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-950" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-3.14 1.346 2.352 1.008a1 1 0 00.788 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-bold text-lg tracking-tight">ERP</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-6 px-3 space-y-1 overflow-y-auto scrollbar-thin">
                <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    </x-slot>
                    لوحة التحكم
                </x-sidebar-link>

                @if(Auth::user()->role === 'admin')
                <x-sidebar-link href="{{ route('employees.index') }}" :active="request()->routeIs('employees.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </x-slot>
                    الموظفين
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('performance.index') }}" :active="request()->routeIs('performance.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </x-slot>
                    تقييم الأداء
                </x-sidebar-link>
                @endif

                <x-sidebar-link href="{{ route('tickets.index') }}" :active="request()->routeIs('tickets.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                    </x-slot>
                    التذاكر
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('leave-requests.index') }}" :active="request()->routeIs('leave-requests.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </x-slot>
                    طلبات الإجازة
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('payroll.index') }}" :active="request()->routeIs('payroll.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </x-slot>
                    مسيرات الرواتب
                </x-sidebar-link>

                <div class="pt-4 mt-4 border-t border-brand-800">
                    <x-sidebar-link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </x-slot>
                        الإعدادات
                    </x-sidebar-link>
                </div>
            </nav>

            {{-- User Info --}}
            <div class="p-4 border-t border-brand-800 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-brand-700 shrink-0 bg-brand-800 flex items-center justify-center text-sm font-bold">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @else
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div x-show="sidebarOpen" x-transition class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-brand-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form x-show="sidebarOpen" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-brand-400 hover:text-white transition-colors" title="تسجيل خروج">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Collapse Toggle --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="absolute top-1/2 -left-3 w-6 h-6 bg-brand-950 border border-brand-700 rounded-full flex items-center justify-center text-brand-400 hover:text-white transition-colors"
            >
                <svg :class="sidebarOpen ? '' : 'rotate-180'" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </aside>

        {{-- ─── Mobile Overlay ─── --}}
        <div x-show="mobileOpen" x-transition.opacity @click="mobileOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        {{-- ─── Mobile Sidebar ─── --}}
        <aside
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-64 bg-brand-950 text-white z-50 lg:hidden flex flex-col"
        >
            <div class="h-16 flex items-center justify-between px-4 border-b border-brand-800">
                <span class="font-bold text-lg">ERP</span>
                <button @click="mobileOpen = false" class="text-brand-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex-1 py-6 px-3 space-y-1 overflow-y-auto">
                <x-sidebar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    </x-slot>
                    لوحة التحكم
                </x-sidebar-link>
                @if(Auth::user()->role === 'admin')
                <x-sidebar-link href="{{ route('employees.index') }}" :active="request()->routeIs('employees.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </x-slot>
                    الموظفين
                </x-sidebar-link>

                <x-sidebar-link href="{{ route('performance.index') }}" :active="request()->routeIs('performance.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </x-slot>
                    تقييم الأداء
                </x-sidebar-link>
                @endif
                <x-sidebar-link href="{{ route('tickets.index') }}" :active="request()->routeIs('tickets.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                    </x-slot>
                    التذاكر
                </x-sidebar-link>
                <x-sidebar-link href="{{ route('leave-requests.index') }}" :active="request()->routeIs('leave-requests.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </x-slot>
                    طلبات الإجازة
                </x-sidebar-link>
                <x-sidebar-link href="{{ route('payroll.index') }}" :active="request()->routeIs('payroll.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </x-slot>
                    مسيرات الرواتب
                </x-sidebar-link>
            </nav>
        </aside>

        {{-- ─── Main Content ─── --}}
        <div :class="sidebarOpen ? 'lg:mr-64' : 'lg:mr-20'" class="flex-1 transition-all duration-300">
            {{-- Top Bar --}}
            <header class="h-16 bg-white/80 backdrop-blur-md border-b border-brand-200/60 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="mobileOpen = true" class="lg:hidden text-brand-600 hover:text-brand-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </button>
                    @isset($header)
                        <h1 class="text-lg font-bold text-brand-900">{{ $header }}</h1>
                    @endisset
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-brand-500 hidden sm:block">{{ now()->translatedFormat('l، j F Y') }}</span>
                    
                    {{-- 🛎️ زر قائمة الإشعارات --}}
                    <div x-data="{
                        open: false,
                        unread: 0,
                        items: [],
                        playSound() {
                            try {
                                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                                const osc = audioCtx.createOscillator();
                                const gain = audioCtx.createGain();
                                osc.type = 'sine';
                                osc.frequency.setValueAtTime(600, audioCtx.currentTime);
                                osc.frequency.exponentialRampToValueAtTime(1200, audioCtx.currentTime + 0.1);
                                gain.gain.setValueAtTime(0, audioCtx.currentTime);
                                gain.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.02);
                                gain.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 0.15);
                                osc.connect(gain);
                                gain.connect(audioCtx.destination);
                                osc.start();
                                osc.stop(audioCtx.currentTime + 0.2);
                            } catch(e) {}
                        }
                    }" 
                    @admin-notification.window="
                        items.unshift($event.detail);
                        unread++;
                        playSound();
                    "
                    class="relative">
                        <button @click="open = !open; unread = 0" class="relative p-2 text-brand-600 hover:text-brand-900 transition-colors bg-brand-100 rounded-full w-10 h-10 flex flex-col items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            <span x-show="unread > 0" x-transition x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full" x-text="unread"></span>
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false" x-transition x-cloak class="absolute left-0 mt-3 w-80 bg-white border border-brand-200 rounded-xl shadow-xl z-50 overflow-hidden transform origin-top-left">
                            <div class="p-3 border-b border-brand-100 bg-brand-50 flex justify-between items-center">
                                <h3 class="font-bold text-sm text-brand-900">الإشعارات الحديثة</h3>
                                <span class="text-xs text-brand-500 font-medium" x-text="items.length + ' إشعار'"></span>
                            </div>
                            <div class="max-h-[22rem] overflow-y-auto w-full">
                                <template x-if="items.length === 0">
                                    <div class="p-6 text-center text-sm text-brand-500">لا توجد إشعارات جديدة</div>
                                </template>
                                <template x-for="(item, index) in items" :key="index">
                                    <a :href="item.link" class="block p-4 border-b border-brand-50 hover:bg-brand-50 transition-colors animate-fade-in">
                                        <div class="flex justify-between items-start mb-1 gap-2">
                                            <span class="font-bold text-sm text-brand-900" x-text="item.title"></span>
                                            <span class="text-xs text-brand-400 whitespace-nowrap" x-text="item.time"></span>
                                        </div>
                                        <p class="text-sm text-brand-600 line-clamp-2" x-text="item.message"></p>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </header>


            {{-- Page Content --}}
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
