@props(['value', 'label', 'icon', 'trend' => null])

<div class="bg-white rounded-2xl shadow-sm border border-brand-100 p-6 hover:shadow-md transition-shadow duration-300 animate-fade-in group">
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1 min-w-0">
            <p class="text-sm text-brand-500 font-medium truncate">{{ $label }}</p>
            <p class="text-3xl font-extrabold text-brand-900 mt-2 truncate">{{ $value }}</p>
            <!-- for trend -->
            @if($trend)
                <p class="text-xs mt-2 truncate {{ str_starts_with($trend, '+') ? 'text-green-600' : 'text-red-600' }}">
                    {{ $trend }}
                </p>
            @endif
        </div>
        <div class="w-12 h-12 shrink-0 bg-brand-950 rounded-xl flex items-center justify-center text-white">
            {{ $icon }}
        </div>
    </div>
</div>
