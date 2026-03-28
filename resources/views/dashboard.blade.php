<x-app-layout>
    <x-slot name="header">لوحة التحكم</x-slot>

    @if(Auth::user()->role === 'admin')
        {{-- Admin Dashboard --}}
        {{-- Stats Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-5 mb-8">
            <x-stat-card label="إجمالي الموظفين" :value="number_format($totalEmployees)">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="إجمالي التذاكر" :value="number_format($totalTickets)" class="stagger-1">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="التذاكر المفتوحة" :value="number_format($openTickets)" class="stagger-2">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="إجمالي طلبات الإجازة" :value="number_format($totalLeaveRequests)" class="stagger-3">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5 0v-2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="طلبات إجازة معلقة" :value="number_format($pendingLeaves)" class="stagger-4">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="الأقسام" :value="number_format($departments)" class="stagger-5">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                </x-slot>
            </x-stat-card>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Recent Employees (2/3) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between p-6 border-b border-brand-50">
                    <h3 class="text-lg font-bold text-brand-900">أحدث الموظفين</h3>
                    <a href="{{ route('employees.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        عرض الكل ←
                    </a>
                </div>
                <div class="divide-y divide-brand-100">
                    @forelse($recentEmployees as $employee)
                        <div class="flex items-center gap-4 p-4 hover:bg-brand-50 transition-colors">
                            <div class="w-10 h-10 bg-brand-950 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                                {{ mb_substr($employee->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-brand-900 truncate">{{ $employee->name }}</p>
                                <p class="text-xs text-brand-500 truncate">{{ $employee->job_title ?? 'غير محدد' }} • {{ $employee->department ?? 'غير محدد' }}</p>
                            </div>
                            <x-badge :status="$employee->status ?? 'active'" />
                        </div>
                    @empty
                        <div class="p-8 text-center text-brand-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                            <p>لا يوجد موظفين حتى الآن</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Tickets (1/3) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in stagger-2 transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between p-6 border-b border-brand-50">
                    <h3 class="text-lg font-bold text-brand-900">آخر التذاكر</h3>
                    <a href="{{ route('tickets.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        عرض الكل ←
                    </a>
                </div>
                <div class="divide-y divide-brand-100">
                    @forelse($recentTickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block p-4 hover:bg-brand-50 transition-colors">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-sm font-semibold text-brand-900 truncate">{{ $ticket->subject }}</p>
                                <x-badge :status="$ticket->status" />
                            </div>
                            <p class="text-xs text-brand-400">{{ $ticket->ticket_number }} • {{ $ticket->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="p-8 text-center text-brand-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                            <p>لا توجد تذاكر</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Leave Requests (1/3) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in stagger-3 transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between p-6 border-b border-brand-50">
                    <h3 class="text-lg font-bold text-brand-900">آخر طلبات الإجازة</h3>
                    <a href="{{ route('leave-requests.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        عرض الكل ←
                    </a>
                </div>
                <div class="divide-y divide-brand-100">
                    @forelse($recentLeaves as $leave)
                        <div class="block p-4 hover:bg-brand-50 transition-colors">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-sm font-semibold text-brand-900 truncate">{{ Str::limit($leave->reason, 40) }}</p>
                                <x-badge :status="$leave->status" />
                            </div>
                            <p class="text-xs text-brand-400">{{ $leave->user->name }} • {{ $leave->start_date->format('Y/m/d') }} — {{ $leave->end_date->format('Y/m/d') }}</p>
                        </div>
                    @empty
                        <div class="p-8 text-center text-brand-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            <p>لا توجد طلبات إجازة</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    @else
        {{-- Employee Dashboard --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <x-stat-card label="إجمالي تذاكري" :value="number_format($myTotalTickets)">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="تذاكري المفتوحة" :value="number_format($myOpenTickets)" class="stagger-1">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="تذاكري المغلقة" :value="number_format($myClosedTickets)" class="stagger-2">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="إجمالي طلبات إجازاتي" :value="number_format($myTotalLeaves)" class="stagger-3">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5 0v-2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="إجازاتي المعلقة" :value="number_format($myPendingLeaves)" class="stagger-4">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </x-slot>
            </x-stat-card>

            <x-stat-card label="إجازاتي المقبولة" :value="number_format($myApprovedLeaves)" class="stagger-5">
                <x-slot name="icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </x-slot>
            </x-stat-card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Employee Recent Tickets --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in stagger-4 transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between p-6 border-b border-brand-50">
                    <h3 class="text-lg font-bold text-brand-900">تذاكري الحديثة</h3>
                    <a href="{{ route('tickets.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        عرض الكل ←
                    </a>
                </div>
                <div class="divide-y divide-brand-100">
                    @forelse($recentTickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}" class="block p-4 hover:bg-brand-50 transition-colors">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-sm font-semibold text-brand-900 truncate">{{ $ticket->subject }}</p>
                                <x-badge :status="$ticket->status" />
                            </div>
                            <p class="text-xs text-brand-400">{{ $ticket->ticket_number }} • {{ $ticket->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="p-8 text-center text-brand-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                            <p>لا توجد تذاكر</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Employee Recent Leaves --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-100 animate-fade-in stagger-5 transition-shadow hover:shadow-md">
                <div class="flex items-center justify-between p-6 border-b border-brand-50">
                    <h3 class="text-lg font-bold text-brand-900">طلبات إجازاتي</h3>
                    <a href="{{ route('leave-requests.index') }}" class="text-sm text-brand-500 hover:text-brand-900 transition-colors font-medium">
                        عرض الكل ←
                    </a>
                </div>
                <div class="divide-y divide-brand-100">
                    @forelse($recentLeaves as $leave)
                        <div class="block p-4 hover:bg-brand-50 transition-colors">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-sm font-semibold text-brand-900 truncate">{{ Str::limit($leave->reason, 40) }}</p>
                                <x-badge :status="$leave->status" />
                            </div>
                            <p class="text-xs text-brand-400">{{ $leave->start_date->format('Y/m/d') }} — {{ $leave->end_date->format('Y/m/d') }}</p>
                        </div>
                    @empty
                        <div class="p-8 text-center text-brand-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            <p>لا توجد طلبات إجازة</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
