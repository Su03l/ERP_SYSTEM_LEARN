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

                @if($leaveRequest->attachment)
                @php
                    $ext = strtolower(pathinfo($leaveRequest->attachment, PATHINFO_EXTENSION));
                @endphp
                <div class="mt-8">
                    <h4 class="text-sm font-bold text-brand-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        المرفقات الطبية / الرسمية
                    </h4>
                    
                    <div class="bg-white border border-brand-100 rounded-2xl overflow-hidden shadow-sm">
                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <div class="relative flex justify-center bg-brand-50/50 p-4">
                                <img src="{{ asset('storage/' . $leaveRequest->attachment) }}" alt="مرفق الإجازة" class="max-w-full max-h-[500px] object-contain rounded-xl shadow-sm border border-brand-100">
                            </div>
                        @elseif(in_array($ext, ['mp4', 'mov', 'webm']))
                            <div class="aspect-video bg-black flex items-center justify-center">
                                <video controls class="w-full h-full">
                                    <source src="{{ asset('storage/' . $leaveRequest->attachment) }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                            </div>
                        @elseif($ext === 'pdf')
                            <div class="aspect-[1/1.4] sm:aspect-video w-full">
                                <iframe src="{{ asset('storage/' . $leaveRequest->attachment) }}" class="w-full h-full border-0"></iframe>
                            </div>
                        @else
                            {{-- Fallback button for unknown files --}}
                            <div class="p-8 text-center flex flex-col items-center justify-center bg-brand-50/50">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 text-brand-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                </div>
                                <h5 class="text-sm font-bold text-brand-900 mb-1">ملف مرفق ({{ strtoupper($ext) }})</h5>
                                <a href="{{ asset('storage/' . $leaveRequest->attachment) }}" target="_blank" class="mt-4 px-6 py-2 bg-brand-900 text-white text-sm font-bold rounded-xl hover:bg-brand-800 transition inline-flex items-center gap-2 shadow-sm focus:ring-2 focus:ring-brand-900 focus:ring-offset-2">
                                    تحميل / فتح الملف
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

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
