<x-app-layout>
    <x-slot name="header">تفاصيل طلب الإجازة الطبية / الرسمية</x-slot>

    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-8">
        
        {{-- ─── Main Content Area (2/3 width) ─── --}}
        <div class="flex-1 space-y-6">
            
            {{-- Primary Header Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">
                <div class="border-b border-brand-100 bg-brand-50/30 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h2 class="text-2xl font-black text-brand-950">
                                نموذج طلب إجازة رسمي
                            </h2>
                            <span class="px-3 py-1 bg-white border border-brand-200 text-brand-800 text-xs font-bold rounded-lg shadow-sm">
                                #{{ str_pad($leaveRequest->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-sm font-semibold text-brand-600">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                تاريخ التقديم: {{ $leaveRequest->created_at->format('Y-m-d') }}
                            </span>
                        </div>
                    </div>
                    <div class="shrink-0 text-left">
                        <x-badge :status="$leaveRequest->status" />
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-sm font-bold text-brand-900 mb-4 flex items-center gap-2 pb-3 border-b border-brand-50">
                        <div class="w-6 h-6 rounded bg-brand-50 text-brand-600 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        مبررات وتفاصيل الطلب
                    </h3>
                    <div class="bg-brand-50/50 rounded-xl p-5 border border-brand-100 text-brand-800 text-[15px] leading-loose whitespace-pre-wrap font-medium">
                        {{ $leaveRequest->reason }}
                    </div>
                </div>

                {{-- Attachment Embedded Viewer --}}
                @if($leaveRequest->attachment)
                @php
                    $ext = strtolower(pathinfo($leaveRequest->attachment, PATHINFO_EXTENSION));
                @endphp
                <div class="border-t border-brand-100 p-6 bg-brand-50/30">
                    <h4 class="text-sm font-bold text-brand-900 mb-4 flex items-center gap-2">
                        <div class="w-6 h-6 rounded bg-white border border-brand-200 text-brand-600 flex items-center justify-center shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        </div>
                        المرفقات الرسمية للإجازة
                    </h4>
                    
                    <div class="bg-white border border-brand-200 rounded-2xl overflow-hidden shadow-sm">
                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <div class="relative group flex justify-center bg-brand-50/50 p-4">
                                <img src="{{ asset('storage/' . $leaveRequest->attachment) }}" alt="مرفق الإجازة" class="max-w-full max-h-[600px] object-contain rounded-xl border border-brand-200 shadow-sm">
                                <div class="absolute inset-0 bg-brand-950/0 group-hover:bg-brand-950/5 transition duration-300 rounded-xl pointer-events-none"></div>
                            </div>
                        @elseif(in_array($ext, ['mp4', 'mov', 'webm']))
                            <div class="aspect-video bg-black flex items-center justify-center">
                                <video controls class="w-full h-full">
                                    <source src="{{ asset('storage/' . $leaveRequest->attachment) }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                            </div>
                        @elseif($ext === 'pdf')
                            <div class="aspect-[1/1.4] sm:aspect-video w-full bg-brand-50">
                                <iframe src="{{ asset('storage/' . $leaveRequest->attachment) }}" class="w-full h-full border-0"></iframe>
                            </div>
                        @else
                            {{-- Fallback button for non-previewable files --}}
                            <div class="p-10 text-center flex flex-col items-center justify-center bg-brand-50/50">
                                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm border border-brand-100 flex items-center justify-center mb-5 text-brand-600">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                </div>
                                <h5 class="text-base font-black text-brand-950 mb-2">مستند مرفق ({{ strtoupper($ext) }})</h5>
                                <p class="text-sm text-brand-500 mb-6 max-w-xs">هذا الامتداد لا يدعم العرض المباشر، الرجاء تحميل الملف لمعاينته.</p>
                                <a href="{{ asset('storage/' . $leaveRequest->attachment) }}" target="_blank" class="px-8 py-3 bg-brand-900 text-white font-bold rounded-xl hover:bg-brand-800 transition inline-flex items-center gap-2 shadow-md hover:shadow-lg focus:ring-2 focus:ring-brand-900 focus:ring-offset-2">
                                    تحميل أو استعراض المستند
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <div class="flex items-center justify-between p-4 bg-white/50 rounded-2xl border border-brand-100">
                <a href="{{ route('leave-requests.index') }}" class="px-6 py-2.5 bg-white border border-brand-200 text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition shadow-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    العودة للقائمة
                </a>
            </div>

        </div>

        {{-- ─── Sidebar (1/3 width) ─── --}}
        <div class="lg:w-96 space-y-6 shrink-0">
            
            {{-- Employee Identity Card --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden">
                <div class="h-16 bg-brand-900 relative"></div>
                <div class="px-6 pb-6 pt-0 relative">
                    <div class="absolute -top-10 right-6 p-1 bg-white rounded-2xl border border-brand-100 shadow-sm">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-brand-50">
                            @if($leaveRequest->user->avatar)
                                <img src="{{ asset('storage/' . $leaveRequest->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($leaveRequest->user->name) }}&color=fff&background=020617&size=200" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                    
                    <div class="pt-8">
                        <p class="text-[11px] font-black text-brand-400 uppercase tracking-wider mb-1">مقدم الطلب</p>
                        <h3 class="text-lg font-black text-brand-950 truncate">{{ $leaveRequest->user->name }}</h3>
                        <p class="text-sm font-medium text-brand-500 truncate mt-0.5">{{ $leaveRequest->user->email }}</p>
                        
                        <div class="mt-4 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 text-xs font-bold rounded-lg border border-brand-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                قسم {{ $leaveRequest->user->department ?? 'الإدارة' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leave Summary & Timeline --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6">
                <h3 class="text-sm font-black text-brand-900 mb-5 flex items-center gap-2 pb-3 border-b border-brand-50">
                    <div class="w-6 h-6 rounded bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    ملخص التواريخ
                </h3>
                
                <div class="space-y-6">
                    <div class="relative pl-4 border-r-2 border-brand-200">
                        <div class="absolute w-2.5 h-2.5 bg-white border-2 border-brand-400 rounded-full top-1.5 -right-[6px]"></div>
                        <p class="text-xs font-bold text-brand-400 uppercase tracking-wide mb-1">النوع</p>
                        <p class="text-sm font-bold text-brand-900">{{ App\Enums\LeaveType::tryFrom($leaveRequest->type)?->getLabel() ?? $leaveRequest->type }}</p>
                    </div>

                    <div class="relative pl-4 border-r-2 border-brand-200">
                        <div class="absolute w-2.5 h-2.5 bg-white border-2 border-brand-600 rounded-full top-1.5 -right-[6px]"></div>
                        <p class="text-xs font-bold text-brand-400 uppercase tracking-wide mb-1">تاريخ البدء</p>
                        <p class="text-sm font-bold text-brand-900">{{ $leaveRequest->start_date->format('Y/m/d') }}</p>
                    </div>

                    <div class="relative pl-4 border-r-2 border-brand-200">
                        <div class="absolute w-2.5 h-2.5 bg-white border-2 border-brand-600 rounded-full top-1.5 -right-[6px]"></div>
                        <p class="text-xs font-bold text-brand-400 uppercase tracking-wide mb-1">تاريخ الانتهاء</p>
                        <p class="text-sm font-bold text-brand-900">{{ $leaveRequest->end_date->format('Y/m/d') }}</p>
                    </div>

                    <div class="bg-brand-50/50 rounded-xl p-4 border border-brand-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-brand-600 uppercase">إجمالي المدة</span>
                        <span class="text-lg font-black text-brand-950">{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} يوم</span>
                    </div>
                </div>
            </div>

            {{-- Admin Actions --}}
            @if(Auth::user()->role === 'admin' && $leaveRequest->status->value === 'pending')
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-brand-900 to-brand-950"></div>
                
                <div class="relative z-10">
                    <h3 class="text-sm font-black text-white mb-4 flex items-center gap-2 pb-3 border-b border-white/10">
                        <div class="w-6 h-6 rounded bg-white/10 text-white flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        </div>
                        قرار الإدارة
                    </h3>
                    <p class="text-xs text-brand-100 font-medium mb-5 leading-relaxed">الرجاء مراجعة المبررات والمرفقات الرسمية (إن وجدت) قبل اتخاذ القرار بالقبول أو الرفض.</p>
                    
                    <div class="flex flex-col gap-3">
                        <form method="POST" action="{{ route('leave-requests.update', $leaveRequest) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="w-full px-4 py-3 bg-white text-brand-900 font-bold rounded-xl hover:bg-brand-50 transition shadow-[0_0_15px_rgba(255,255,255,0.1)] flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                قبول واعتماد الطلب
                            </button>
                        </form>
                        <form method="POST" action="{{ route('leave-requests.update', $leaveRequest) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="w-full px-4 py-3 bg-transparent border border-white/20 text-white font-bold rounded-xl hover:bg-white/10 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                رفض الطلب
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

        </div>

    </div>
</x-app-layout>
