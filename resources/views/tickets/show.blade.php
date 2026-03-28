<x-app-layout>
    <x-slot name="header">تفاصيل التذكرة</x-slot>

    <div class="max-w-3xl">
        {{-- Ticket Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 mb-6 animate-fade-in">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-sm font-mono font-semibold text-brand-500 bg-brand-100 px-2.5 py-1 rounded-lg">{{ $ticket->ticket_number }}</span>
                            <x-badge :status="$ticket->status" />
                        </div>
                        <h2 class="text-2xl font-extrabold text-brand-900">{{ $ticket->subject }}</h2>
                    </div>
                    @if(Auth::user()->role === 'admin' && $ticket->status->value !== 'closed')
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="flex gap-2">
                            @csrf
                            @method('PUT')
                            <select name="status" class="px-3 py-2 bg-brand-50 border border-brand-200 rounded-xl text-sm text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-950 transition">
                                <option value="open" {{ $ticket->status->value === 'open' ? 'selected' : '' }}>مفتوحة</option>
                                <option value="in_progress" {{ $ticket->status->value === 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                                <option value="closed" {{ $ticket->status->value === 'closed' ? 'selected' : '' }}>مغلقة</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-brand-950 text-white font-semibold rounded-xl hover:bg-brand-800 transition text-sm">
                                تحديث
                            </button>
                        </form>
                    @endif
                </div>

                <div class="flex items-center gap-4 text-sm text-brand-500">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-brand-950 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ mb_substr($ticket->user->name, 0, 1) }}
                        </div>
                        <span>{{ $ticket->user->name }}</span>
                    </div>
                    <span>•</span>
                    <span>{{ $ticket->created_at->translatedFormat('j F Y — h:i A') }}</span>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 mb-6 animate-fade-in stagger-1">
            <div class="p-6 border-b border-brand-50">
                <h3 class="text-base font-bold text-brand-900">تفاصيل المشكلة</h3>
            </div>
            <div class="p-6">
                <p class="text-brand-700 leading-relaxed whitespace-pre-wrap">{{ $ticket->description }}</p>
            </div>
        </div>

        {{-- Status Timeline --}}
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in stagger-2">
            <div class="p-6 border-b border-brand-50">
                <h3 class="text-base font-bold text-brand-900">المسار الزمني</h3>
            </div>
            <div class="p-6">
                <div class="relative border-r-2 border-brand-200 pr-8 space-y-8">
                    <div class="relative">
                        <div class="absolute -right-[25px] w-4 h-4 bg-brand-950 rounded-full border-4 border-white"></div>
                        <p class="text-sm font-semibold text-brand-900">تم إنشاء التذكرة</p>
                        <p class="text-xs text-brand-400 mt-0.5">{{ $ticket->created_at->translatedFormat('j F Y — h:i A') }}</p>
                    </div>
                    @if($ticket->status->value !== 'open')
                        <div class="relative">
                            <div class="absolute -right-[25px] w-4 h-4 bg-brand-600 rounded-full border-4 border-white"></div>
                            <p class="text-sm font-semibold text-brand-900">قيد المعالجة</p>
                            <p class="text-xs text-brand-400 mt-0.5">تم تحويل التذكرة للمعالجة</p>
                        </div>
                    @endif
                    @if($ticket->status->value === 'closed')
                        <div class="relative">
                            <div class="absolute -right-[25px] w-4 h-4 bg-brand-300 rounded-full border-4 border-white"></div>
                            <p class="text-sm font-semibold text-brand-900">مغلقة</p>
                            <p class="text-xs text-brand-400 mt-0.5">تم إغلاق التذكرة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('tickets.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                ← العودة لقائمة التذاكر
            </a>
        </div>
    </div>
</x-app-layout>
