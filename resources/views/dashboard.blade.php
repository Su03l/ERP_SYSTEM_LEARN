<x-app-layout>
    <x-slot name="header">لوحة التحكم</x-slot>

    @if(in_array(Auth::user()->role, ['admin', 'supervisor']))
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{--                      ADMIN DASHBOARD                             --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}

    {{-- Page Heading --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-brand-950">مرحباً، {{ Auth::user()->name }}</h1>
            <p class="text-sm text-brand-500 font-medium mt-1">{{ now()->translatedFormat('l، j F Y') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('employees.create') }}" class="px-4 py-2.5 bg-brand-950 text-white text-sm font-bold rounded-xl hover:bg-brand-800 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                موظف جديد
            </a>
        </div>
    </div>

    {{-- KPI Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-brand-100 p-5">
            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest">الموظفين</p>
            <p class="text-3xl font-black text-brand-950 mt-2">{{ number_format($totalEmployees) }}</p>
            <p class="text-xs text-brand-400 font-medium mt-1">{{ number_format($departments) }} قسم</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-5">
            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest">التذاكر</p>
            <p class="text-3xl font-black text-brand-950 mt-2">{{ number_format($totalTickets) }}</p>
            <p class="text-xs text-brand-400 font-medium mt-1">{{ $openTickets }} مفتوحة / {{ $inProgressTickets }} قيد المعالجة</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-5">
            <p class="text-[11px] font-bold text-brand-400 uppercase tracking-widest">الإجازات</p>
            <p class="text-3xl font-black text-brand-950 mt-2">{{ number_format($totalLeaveRequests) }}</p>
            <p class="text-xs text-brand-400 font-medium mt-1">{{ $approvedLeaves }} مقبولة / {{ $rejectedLeaves }} مرفوضة</p>
        </div>
        <div class="bg-brand-950 rounded-xl p-5 text-white">
            <p class="text-[11px] font-bold text-brand-300 uppercase tracking-widest">بحاجة لقرار</p>
            <p class="text-3xl font-black mt-2">{{ number_format($pendingLeaves + $openTickets) }}</p>
            <p class="text-xs text-brand-300 font-medium mt-1">{{ $pendingLeaves }} إجازة + {{ $openTickets }} تذكرة</p>
        </div>
    </div>

    {{-- Ticket & Leave Distribution Bars --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
        {{-- Ticket Distribution --}}
        <div class="bg-white rounded-xl border border-brand-100 p-5">
            <h3 class="text-xs font-bold text-brand-900 uppercase tracking-widest mb-4">توزيع حالات التذاكر</h3>
            @if($totalTickets > 0)
            <div class="h-3 rounded-full bg-brand-50 overflow-hidden flex">
                @if($openTickets > 0)
                <div class="bg-brand-400 h-full transition-all" style="width: {{ ($openTickets / $totalTickets) * 100 }}%"></div>
                @endif
                @if($inProgressTickets > 0)
                <div class="bg-brand-700 h-full transition-all" style="width: {{ ($inProgressTickets / $totalTickets) * 100 }}%"></div>
                @endif
                @if($closedTickets > 0)
                <div class="bg-brand-950 h-full transition-all" style="width: {{ ($closedTickets / $totalTickets) * 100 }}%"></div>
                @endif
            </div>
            <div class="flex items-center gap-5 mt-3 text-xs font-medium text-brand-500">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-brand-400 inline-block"></span> مفتوحة {{ $openTickets }}</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-brand-700 inline-block"></span> قيد المعالجة {{ $inProgressTickets }}</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-brand-950 inline-block"></span> مغلقة {{ $closedTickets }}</span>
            </div>
            @else
            <p class="text-sm text-brand-400 font-medium">لا توجد بيانات</p>
            @endif
        </div>

        {{-- Leave Distribution --}}
        <div class="bg-white rounded-xl border border-brand-100 p-5">
            <h3 class="text-xs font-bold text-brand-900 uppercase tracking-widest mb-4">توزيع حالات الإجازات</h3>
            @if($totalLeaveRequests > 0)
            <div class="h-3 rounded-full bg-brand-50 overflow-hidden flex">
                @if($pendingLeaves > 0)
                <div class="bg-brand-300 h-full transition-all" style="width: {{ ($pendingLeaves / $totalLeaveRequests) * 100 }}%"></div>
                @endif
                @if($approvedLeaves > 0)
                <div class="bg-brand-700 h-full transition-all" style="width: {{ ($approvedLeaves / $totalLeaveRequests) * 100 }}%"></div>
                @endif
                @if($rejectedLeaves > 0)
                <div class="bg-brand-950 h-full transition-all" style="width: {{ ($rejectedLeaves / $totalLeaveRequests) * 100 }}%"></div>
                @endif
            </div>
            <div class="flex items-center gap-5 mt-3 text-xs font-medium text-brand-500">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-brand-300 inline-block"></span> معلقة {{ $pendingLeaves }}</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-brand-700 inline-block"></span> مقبولة {{ $approvedLeaves }}</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-brand-950 inline-block"></span> مرفوضة {{ $rejectedLeaves }}</span>
            </div>
            @else
            <p class="text-sm text-brand-400 font-medium">لا توجد بيانات</p>
            @endif
        </div>
    </div>

    {{-- Main Content: 3 Column Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Recent Employees --}}
        <div class="bg-white rounded-xl border border-brand-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-brand-100">
                <h3 class="text-sm font-bold text-brand-900">آخر الموظفين</h3>
                <a href="{{ route('employees.index') }}" class="text-xs font-bold text-brand-500 hover:text-brand-900 transition">عرض الكل</a>
            </div>
            <div class="divide-y divide-brand-50">
                @forelse($recentEmployees as $employee)
                    <a href="{{ route('employees.show', $employee) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-brand-50/50 transition group">
                        <div class="w-9 h-9 rounded-lg overflow-hidden border border-brand-100 shrink-0">
                            @if($employee->avatar)
                                <img src="{{ asset('storage/' . $employee->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-brand-950 flex items-center justify-center text-white text-xs font-black">{{ mb_substr($employee->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-brand-900 truncate">{{ $employee->name }}</p>
                            <p class="text-[11px] text-brand-400 truncate font-medium">{{ $employee->department ?? 'غير محدد' }}</p>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-brand-400 font-medium">لا يوجد موظفين</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Tickets --}}
        <div class="bg-white rounded-xl border border-brand-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-brand-100">
                <h3 class="text-sm font-bold text-brand-900">آخر التذاكر</h3>
                <a href="{{ route('tickets.index') }}" class="text-xs font-bold text-brand-500 hover:text-brand-900 transition">عرض الكل</a>
            </div>
            <div class="divide-y divide-brand-50">
                @forelse($recentTickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="block px-5 py-3 hover:bg-brand-50/50 transition group">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <p class="text-sm font-bold text-brand-900 truncate">{{ $ticket->subject }}</p>
                            <x-badge :status="$ticket->status" />
                        </div>
                        <div class="flex items-center gap-2 text-[11px] text-brand-400 font-medium">
                            <span class="font-mono">{{ $ticket->ticket_number }}</span>
                            <span>{{ $ticket->user->name ?? '---' }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-brand-400 font-medium">لا توجد تذاكر</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Leave Requests --}}
        <div class="bg-white rounded-xl border border-brand-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-brand-100">
                <h3 class="text-sm font-bold text-brand-900">آخر طلبات الإجازة</h3>
                <a href="{{ route('leave-requests.index') }}" class="text-xs font-bold text-brand-500 hover:text-brand-900 transition">عرض الكل</a>
            </div>
            <div class="divide-y divide-brand-50">
                @forelse($recentLeaves as $leave)
                    <a href="{{ route('leave-requests.show', $leave) }}" class="block px-5 py-3 hover:bg-brand-50/50 transition group">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <p class="text-sm font-bold text-brand-900 truncate">{{ Str::limit($leave->reason, 30) }}</p>
                            <x-badge :status="$leave->status" />
                        </div>
                        <div class="flex items-center gap-2 text-[11px] text-brand-400 font-medium">
                            <span>{{ $leave->user->name }}</span>
                            <span dir="ltr">{{ $leave->start_date->format('m/d') }} - {{ $leave->end_date->format('m/d') }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-brand-400 font-medium">لا توجد طلبات إجازة</div>
                @endforelse
            </div>
        </div>

    </div>

    @else
    {{-- ══════════════════════════════════════════════════════════════════ --}}
    {{--                    EMPLOYEE DASHBOARD                            --}}
    {{-- ══════════════════════════════════════════════════════════════════ --}}

    {{-- Page Heading --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl overflow-hidden border border-brand-100 shadow-sm shrink-0">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-brand-950 flex items-center justify-center text-white text-xl font-black">{{ mb_substr(Auth::user()->name, 0, 1) }}</div>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-black text-brand-950">{{ Auth::user()->name }}</h1>
                <p class="text-sm text-brand-500 font-medium mt-0.5">{{ Auth::user()->job_title ?? 'موظف' }} -- {{ Auth::user()->department ?? 'غير محدد' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('tickets.create') }}" class="px-4 py-2.5 bg-brand-950 text-white text-sm font-bold rounded-xl hover:bg-brand-800 transition shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                تذكرة جديدة
            </a>
            <a href="{{ route('leave-requests.create') }}" class="px-4 py-2.5 bg-white border border-brand-200 text-brand-700 text-sm font-bold rounded-xl hover:bg-brand-50 transition shadow-sm flex items-center gap-2">
                طلب إجازة
            </a>
        </div>
    </div>

    {{-- Employee KPI Row --}}
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mb-6">
        <div class="bg-white rounded-xl border border-brand-100 p-4 text-center">
            <p class="text-2xl font-black text-brand-950">{{ $myTotalTickets }}</p>
            <p class="text-[10px] font-bold text-brand-400 mt-1 uppercase tracking-wider">تذاكري</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-4 text-center">
            <p class="text-2xl font-black text-brand-950">{{ $myOpenTickets }}</p>
            <p class="text-[10px] font-bold text-brand-400 mt-1 uppercase tracking-wider">مفتوحة</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-4 text-center">
            <p class="text-2xl font-black text-brand-950">{{ $myClosedTickets }}</p>
            <p class="text-[10px] font-bold text-brand-400 mt-1 uppercase tracking-wider">مغلقة</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-4 text-center">
            <p class="text-2xl font-black text-brand-950">{{ $myTotalLeaves }}</p>
            <p class="text-[10px] font-bold text-brand-400 mt-1 uppercase tracking-wider">إجازاتي</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-4 text-center">
            <p class="text-2xl font-black text-brand-950">{{ $myPendingLeaves }}</p>
            <p class="text-[10px] font-bold text-brand-400 mt-1 uppercase tracking-wider">معلقة</p>
        </div>
        <div class="bg-white rounded-xl border border-brand-100 p-4 text-center">
            <p class="text-2xl font-black text-brand-950">{{ $myApprovedLeaves }}</p>
            <p class="text-[10px] font-bold text-brand-400 mt-1 uppercase tracking-wider">مقبولة</p>
        </div>
    </div>

    {{-- Employee Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- My Tickets --}}
        <div class="bg-white rounded-xl border border-brand-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-brand-100">
                <h3 class="text-sm font-bold text-brand-900">تذاكري الأخيرة</h3>
                <a href="{{ route('tickets.index') }}" class="text-xs font-bold text-brand-500 hover:text-brand-900 transition">عرض الكل</a>
            </div>
            <div class="divide-y divide-brand-50">
                @forelse($recentTickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="block px-5 py-3 hover:bg-brand-50/50 transition">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <p class="text-sm font-bold text-brand-900 truncate">{{ $ticket->subject }}</p>
                            <x-badge :status="$ticket->status" />
                        </div>
                        <p class="text-[11px] text-brand-400 font-medium font-mono">{{ $ticket->ticket_number }} -- {{ $ticket->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-brand-400 font-medium">لا توجد تذاكر</div>
                @endforelse
            </div>
        </div>

        {{-- My Leaves --}}
        <div class="bg-white rounded-xl border border-brand-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-brand-100">
                <h3 class="text-sm font-bold text-brand-900">طلبات إجازاتي</h3>
                <a href="{{ route('leave-requests.index') }}" class="text-xs font-bold text-brand-500 hover:text-brand-900 transition">عرض الكل</a>
            </div>
            <div class="divide-y divide-brand-50">
                @forelse($recentLeaves as $leave)
                    <a href="{{ route('leave-requests.show', $leave) }}" class="block px-5 py-3 hover:bg-brand-50/50 transition">
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <p class="text-sm font-bold text-brand-900 truncate">{{ Str::limit($leave->reason, 35) }}</p>
                            <x-badge :status="$leave->status" />
                        </div>
                        <p class="text-[11px] text-brand-400 font-medium" dir="ltr">{{ $leave->start_date->format('Y/m/d') }} - {{ $leave->end_date->format('Y/m/d') }}</p>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-brand-400 font-medium">لا توجد طلبات إجازة</div>
                @endforelse
            </div>
        </div>

    </div>
    @endif
</x-app-layout>
