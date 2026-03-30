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

        @if($ticket->attachment)
        {{-- Attachment --}}
        <div class="bg-white rounded-2xl shadow-sm border border-brand-100 mb-6 animate-fade-in stagger-2 relative overflow-hidden group" x-data="{ showAttachmentModal: false }">
            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm3.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-brand-900 mb-1">المرفقات الإضافية</h3>
                        <p class="text-xs text-brand-500">تم إرفاق ملف مع هذه التذكرة لمزيد من التوضيح.</p>
                    </div>
                </div>
                <button type="button" @click="showAttachmentModal = true" class="px-5 py-2.5 bg-brand-50 border border-brand-200 text-brand-700 font-bold text-sm rounded-xl hover:bg-brand-100 transition shadow-sm whitespace-nowrap hidden sm:block">
                    مشاهدة المرفق
                </button>
                <button type="button" @click="showAttachmentModal = true" class="w-full py-2.5 bg-brand-50 border border-brand-200 text-brand-700 font-bold text-sm rounded-xl hover:bg-brand-100 transition shadow-sm whitespace-nowrap sm:hidden">
                    مشاهدة المرفق
                </button>
            </div>

            {{-- Attachment Viewing Modal --}}
            <div x-show="showAttachmentModal" style="display: none;" x-transition.opacity class="fixed inset-0 min-h-screen bg-brand-950/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div @click.outside="showAttachmentModal = false" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white rounded-3xl w-full max-w-5xl p-2 shadow-2xl relative border border-brand-100 flex flex-col h-[85vh]">
                    {{-- Close Button & Header --}}
                    <div class="flex justify-between items-center p-4 border-b border-brand-100 mb-2">
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-bold text-brand-900">مستعرض المرفقات</h3>
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" download class="text-xs bg-brand-100 text-brand-700 px-3 py-1.5 rounded-lg hover:bg-brand-200 transition font-bold">
                                تحميل الملف ⬇
                            </a>
                        </div>
                        <button type="button" @click="showAttachmentModal = false" class="w-8 h-8 flex items-center justify-center text-brand-400 hover:text-brand-900 bg-brand-50 hover:bg-brand-100 rounded-full transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    
                    {{-- Iframe Container --}}
                    <div class="flex-1 bg-brand-50/50 rounded-2xl overflow-hidden relative border border-brand-100">
                        <iframe src="{{ asset('storage/' . $ticket->attachment) }}" class="w-full h-full border-0"></iframe>
                    </div>
                </div>
            </div>
        </div>
        @endif

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
