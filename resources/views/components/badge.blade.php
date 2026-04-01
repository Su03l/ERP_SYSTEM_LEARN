@props(['status'])

<!-- for badge status -->
@php
    $map = [
        'active' => ['bg-brand-950 text-white', 'نشط'],
        'inactive' => ['bg-brand-200 text-brand-600', 'غير نشط'],
        'pending' => ['bg-brand-300 text-brand-800', 'قيد الانتظار'],
        'approved' => ['bg-brand-950 text-white', 'مقبول'],
        'rejected' => ['bg-brand-400 text-white', 'مرفوض'],
        'open' => ['bg-brand-800 text-white', 'مفتوحة'],
        'in_progress' => ['bg-brand-600 text-white', 'قيد المعالجة'],
        'closed' => ['bg-brand-300 text-brand-700', 'مغلقة'],
    ];

    // for badge status
    $statusValue = is_object($status) ? $status->value : $status;
    $style = $map[$statusValue] ?? ['bg-brand-200 text-brand-700', $statusValue];
@endphp

<!-- for badge status -->
<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $style[0] }}">
    {{ $style[1] }}
</span>
