<x-app-layout>
    <x-slot name="header">تفاصيل التذكرة - {{ $ticket->ticket_number }}</x-slot>

    <div class="max-w-7xl mx-auto pb-12 w-full mt-4 flex flex-col lg:flex-row gap-6 lg:gap-8 px-4 sm:px-6 lg:px-8">
        
        {{-- ─── Main Content Area (2/3 width) ─── --}}
        <div class="flex-1 w-full space-y-6 animate-fade-in">
            
            {{-- Ticket Header Card --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden border-t-4 border-t-brand-900 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-50 rounded-bl-full -z-10 opacity-50"></div>
                <div class="p-6 sm:p-8 z-10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 border-b border-brand-50 pb-5">
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-mono font-bold text-brand-900 bg-brand-50 border border-brand-100 px-3 py-1.5 rounded-lg shadow-sm">
                                {{ $ticket->ticket_number }}
                            </span>
                            <x-badge :status="$ticket->status" />
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-brand-500 bg-brand-50/50 px-3 py-1.5 rounded-lg border border-brand-100">
                            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>تاريخ النشر:</span>
                            <span>{{ $ticket->created_at->translatedFormat('j F Y - h:i A') }}</span>
                        </div>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-brand-950 mb-2 leading-snug">{{ $ticket->subject }}</h1>
                </div>
            </div>

            {{-- Description Card --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-brand-50 bg-brand-50/20 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707v14a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h2 class="text-lg font-black text-brand-900">الوصف والتفاصيل</h2>
                </div>
                <div class="p-6 sm:p-8 min-h-[150px]">
                    <p class="text-brand-800 leading-relaxed whitespace-pre-wrap text-[15px]">{{ $ticket->description }}</p>
                </div>
            </div>

            {{-- Attachment Embedded Viewer --}}
            @if($ticket->attachment)
            @php
                $ext = pathinfo($ticket->attachment, PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'webm', 'ogg']);
            @endphp
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-brand-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-brand-50/20">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center shadow-inner">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm3.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75z"></path></svg>
                        </div>
                        <h2 class="text-lg font-black text-brand-900">المرفق الإضافي لمعاينة المشكلة</h2>
                    </div>
                    <a href="{{ asset('storage/' . $ticket->attachment) }}" download class="text-xs bg-white border border-brand-200 text-brand-700 font-bold px-4 py-2.5 rounded-xl hover:bg-brand-50 transition shadow-sm flex items-center gap-2 w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        تحميل الملف
                    </a>
                </div>
                
                <div class="p-4 md:p-6 bg-brand-50/10 flex justify-center items-center m-auto w-full">
                    @if($isImage)
                        <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="مرفق التذكرة" class="max-w-full h-auto rounded-xl shadow-sm border border-brand-100 max-h-[700px] object-contain bg-white">
                    @elseif($isVideo)
                        <video controls class="w-full max-h-[600px] rounded-xl shadow-sm border border-brand-200 bg-black">
                            <source src="{{ asset('storage/' . $ticket->attachment) }}" type="video/{{ strtolower($ext) == 'mov' ? 'quicktime' : strtolower($ext) }}">
                            متصفحك لا يدعم عرض الفيديو.
                        </video>
                    @else
                        {{-- PDF or others --}}
                        <div class="w-full bg-brand-50 p-2 rounded-xl border border-brand-100">
                            <iframe src="{{ asset('storage/' . $ticket->attachment) }}" class="w-full h-[600px] rounded-lg bg-white border-0 shadow-sm"></iframe>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- ─── Discussion / Comments Section ─── --}}
            <div class="mt-8 space-y-6">
                <h3 class="text-xl font-black text-brand-950 flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    سجل المتابعة والردود
                </h3>

                {{-- Comments Loop --}}
                @foreach($ticket->comments as $comment)
                <div class="flex gap-4 {{ $comment->user_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                    <div class="w-12 h-12 rounded-full border border-brand-100 shadow-sm overflow-hidden shrink-0">
                        @if($comment->user->avatar)
                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&color=fff&background={{ $comment->user->role === 'admin' ? '020617' : '0ea5e9' }}&size=200" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 max-w-[85%]">
                        <div class="bg-white p-5 rounded-2xl shadow-sm border {{ $comment->user->role === 'admin' ? 'border-brand-300 bg-brand-50/10' : 'border-brand-50' }} {{ $comment->user_id === Auth::id() ? 'rounded-tr-none' : 'rounded-tl-none' }}">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                <h4 class="font-bold text-sm text-brand-900">
                                    {{ $comment->user->name }}
                                    @if($comment->user->role === 'admin')
                                        <span class="bg-brand-900 text-white text-[10px] px-2 py-0.5 rounded-full ml-1">الإدارة</span>
                                    @endif
                                </h4>
                                <span class="text-xs text-brand-400 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[14px] text-brand-800 leading-relaxed whitespace-pre-wrap">{{ $comment->content }}</p>
                            
                            @if($comment->status_change)
                                <div class="mt-4 pt-3 border-t border-brand-100 flex items-center gap-2 text-xs font-bold text-brand-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    مع هذا الرد، تم تغيير حالة التذكرة إلى: 
                                    <span class="bg-white px-2 py-1 rounded-md border border-brand-200">
                                        {{ App\Enums\TicketStatus::tryFrom($comment->status_change)?->getLabel() ?? $comment->status_change }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                @if($ticket->comments->isEmpty())
                <div class="bg-brand-50/50 rounded-2xl border border-brand-100 border-dashed p-8 text-center">
                    <svg class="w-8 h-8 text-brand-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <p class="text-brand-500 font-medium text-sm">لا توجد ردود بعد. أضف الرد الأول!</p>
                </div>
                @endif

                {{-- Add Reply Form --}}
                <div class="bg-white rounded-2xl border border-brand-200 shadow-lg p-6 mt-6">
                    <form action="{{ route('ticket.comments.store', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="sr-only">نص الرد</label>
                            <textarea name="content" id="content" rows="4" required placeholder="اكتب ردك أو استفسارك هنا..." class="w-full bg-brand-50 border border-brand-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-900 transition resize-none"></textarea>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            @if(Auth::user()->role === 'admin')
                            {{-- Admin Status Change Integrated --}}
                            <div class="flex-1 max-w-sm">
                                <label class="block text-xs font-bold text-brand-600 mb-1.5 uppercase tracking-wide">الإدارة: تغيير الحالة مع الرد؟</label>
                                <div class="relative">
                                    <select name="status" class="w-full pl-10 pr-4 py-2 bg-white border border-brand-200 rounded-xl text-sm font-bold text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-900 transition appearance-none">
                                        <option value="open" {{ $ticket->status->value === 'open' ? 'selected' : '' }}>مفتوحة</option>
                                        <option value="in_progress" {{ $ticket->status->value === 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                                        <option value="closed" {{ $ticket->status->value === 'closed' ? 'selected' : '' }}>مغلقة</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-brand-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @else
                            <div class="flex-1"></div>
                            @endif

                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-brand-900 text-white font-bold rounded-xl hover:bg-brand-800 transition shadow-md flex items-center justify-center gap-2">
                                إرسال الرد
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- ─── Sidebar (1/3 width) ─── --}}
        <div class="w-full lg:w-1/3 shrink-0 space-y-6 animate-slide-up stagger-1">
            
            {{-- Requester Info Card --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-brand-400"></div>
                <h3 class="text-xs font-black text-brand-400 mb-5 uppercase tracking-wider">المرسل / مقدم الطلب</h3>
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-14 h-14 rounded-full border border-brand-100 shadow-sm overflow-hidden shrink-0">
                        @if($ticket->user->avatar)
                            <img src="{{ asset('storage/' . $ticket->user->avatar) }}" alt="{{ $ticket->user->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&color=fff&background=020617&size=200" alt="{{ $ticket->user->name }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-base font-black text-brand-950 truncate">{{ $ticket->user->name }}</h4>
                        <p class="text-xs text-brand-500 mt-1 truncate font-medium">{{ $ticket->user->job_title ?? 'موظف' }}</p>
                    </div>
                </div>
                <a href="mailto:{{ $ticket->user->email }}" class="w-full flex items-center justify-center gap-2 text-xs font-bold text-brand-700 bg-brand-50 hover:bg-brand-100 transition py-2.5 rounded-xl border border-brand-100 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    التواصل للمتابعة
                </a>
            </div>

            {{-- The standalone Status Management block was removed and integrated into the reply box --}}

            {{-- Timeline Card --}}
            <div class="bg-white rounded-2xl border border-brand-100 shadow-sm p-6">
                <h3 class="text-sm font-black text-brand-900 mb-6 flex items-center gap-2 pb-3 border-b border-brand-50">
                    <div class="w-6 h-6 rounded bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    المسار الزمني
                </h3>
                <div class="relative border-r-2 border-brand-100 pr-5 space-y-7 ml-2">
                    <div class="relative">
                        <div class="absolute -right-[29px] w-4 h-4 bg-brand-900 rounded-full border-4 border-white shadow-sm ring-2 ring-brand-100"></div>
                        <p class="text-sm font-bold text-brand-900">إنشاء التذكرة</p>
                        <p class="text-xs text-brand-500 mt-1 font-medium">{{ $ticket->created_at->translatedFormat('j F Y - h:i A') }}</p>
                    </div>
                    
                    @if($ticket->status->value !== 'open')
                        <div class="relative">
                            <div class="absolute -right-[29px] w-4 h-4 bg-yellow-500 rounded-full border-4 border-white shadow-sm ring-2 ring-yellow-100"></div>
                            <p class="text-sm font-bold text-brand-900">قيد المعالجة</p>
                            <p class="text-xs text-brand-500 mt-1 font-medium">تم بدء العمل على المشكلة</p>
                        </div>
                    @else
                        <div class="relative opacity-40">
                            <div class="absolute -right-[29px] w-4 h-4 bg-brand-100 rounded-full border-4 border-white shadow-sm"></div>
                            <p class="text-sm font-bold text-brand-900">قيد المعالجة</p>
                            <p class="text-xs text-brand-400 mt-1 font-medium">في الانتظار</p>
                        </div>
                    @endif
                    
                    @if($ticket->status->value === 'closed')
                        <div class="relative">
                            <div class="absolute -right-[29px] w-4 h-4 bg-red-600 rounded-full border-4 border-white shadow-sm ring-2 ring-red-100"></div>
                            <p class="text-sm font-bold text-brand-900">إغلاق التذكرة بنجاح</p>
                            <p class="text-xs text-brand-500 mt-1 font-medium">{{ $ticket->updated_at->translatedFormat('j F Y - h:i A') }}</p>
                        </div>
                    @elseif($ticket->status->value !== 'closed')
                        <div class="relative opacity-40">
                            <div class="absolute -right-[29px] w-4 h-4 bg-brand-100 rounded-full border-4 border-white shadow-sm"></div>
                            <p class="text-sm font-bold text-brand-900">مغلقة</p>
                            <p class="text-xs text-brand-400 mt-1 font-medium">الخطوة النهائية</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Back button --}}
            <a href="{{ route('tickets.index') }}" class="w-full flex justify-center items-center gap-2 px-4 py-3.5 bg-white border border-brand-200 text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition drop-shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                العودة للقائمة الرئيسية
            </a>
        </div>
        
    </div>
</x-app-layout>
