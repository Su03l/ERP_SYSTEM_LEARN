@props(['href', 'active' => false])

<!-- for sidebar link -->
@php
    $classes = $active
        ? 'flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white font-medium shadow-[inset_-3px_0_0_0_#fff]'
        : 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-brand-400 hover:bg-white/5 hover:text-white transition-all duration-200';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <span class="shrink-0">{{ $icon }}</span>
    <span x-show="sidebarOpen" x-transition class="text-sm">{{ $slot }}</span>
</a>
