<x-app-layout>
    <x-slot name="header">تفاصيل طلب الإجازة</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-brand-200 animate-fade-in">
            <div class="p-6 border-b border-brand-100">
                <h3 class="text-lg font-bold text-brand-900">طلب الإجازة رقم {{ $leaveRequest->id }}</h3>
                <p class="text-sm text-brand-500 mt-1">تفاصيل طلب الإجازة المقدم من {{ $leaveRequest->user->name }}</p>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <p class="text-sm font-semibold text-brand-700 mb-1.5">الموظف:</p>
                        <p class="text-brand-900">{{ $leaveRequest->user->name }} ({{ $leaveRequest->user->email }})</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-brand-700 mb-1.5">نوع الإجازة:</p>
                        <p class="text-brand-900">{{ $leaveRequest->type }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <p class="text-sm font-semibold text-brand-700 mb-1.5">تاريخ البداية:</p>
                        <p class="text-brand-900">{{ $leaveRequest->start_date->format('Y/m/d') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-brand-700 mb-1.5">تاريخ النهاية:</p>
                        <p class="text-brand-900">{{ $leaveRequest->end_date->format('Y/m/d') }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-semibold text-brand-700 mb-1.5">المدة:</p>
                    <p class="text-brand-900">{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} يوم</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-brand-700 mb-1.5">السبب:</p>
                    <p class="text-brand-900">{{ $leaveRequest->reason }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-brand-700 mb-1.5">الحالة:</p>
                    <x-badge :status="$leaveRequest->status" />
                </div>

                @if(Auth::user()->role === 'admin' && $leaveRequest->status->value === 'pending')
                    <div class="pt-6 border-t border-brand-100 flex items-center gap-3">
                        <form method="POST" action="{{ route('leave-requests.update', $leaveRequest) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                قبول الطلب
                            </button>
                        </form>
                        <form method="POST" action="{{ route('leave-requests.update', $leaveRequest) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                رفض الطلب
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between p-6 border-t border-brand-100">
                <a href="{{ route('leave-requests.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                    ← العودة إلى قائمة طلبات الإجازة
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
