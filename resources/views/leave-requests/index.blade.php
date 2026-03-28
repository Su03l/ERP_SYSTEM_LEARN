<x-app-layout>
    <x-slot name="header">طلبات الإجازة</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-brand-500 text-sm">إجمالي {{ $leaveRequests->total() }} طلب</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('leave-requests.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" name="search" placeholder="بحث بالسبب أو النوع أو اسم الموظف..."
                       value="{{ request('search') }}"
                       class="border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500">
                <select name="status" class="border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبول</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                </select>
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    بحث
                </button>
            </form>
            <a href="{{ route('leave-requests.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                طلب إجازة جديد
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b border-brand-100 bg-white">
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">الموظف</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">النوع</th> {{-- Added Type column --}}
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">من</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">إلى</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">المدة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">السبب</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider text-center">عرض</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($leaveRequests as $leave)
                        <tr class="hover:bg-brand-50/50 transition-all duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-brand-950 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ mb_substr($leave->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-brand-900">{{ $leave->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $leave->type }}</td> {{-- Display Type --}}
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $leave->start_date->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $leave->end_date->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 text-sm text-brand-600">
                                {{ $leave->start_date->diffInDays($leave->end_date) + 1 }} يوم
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-600 truncate max-w-[200px]">{{ $leave->reason }}</td>
                            <td class="px-6 py-4">
                                <x-badge :status="$leave->status" />
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('leave-requests.show', $leave) }}" class="p-2 text-brand-400 hover:text-brand-900 hover:bg-brand-100 rounded-lg transition-colors inline-flex" title="عرض التفاصيل">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center"> {{-- Updated colspan --}}
                                <svg class="w-16 h-16 mx-auto mb-4 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                <p class="text-brand-400 text-lg">لا توجد طلبات إجازة</p>
                                <a href="{{ route('leave-requests.create') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-brand-950 text-white font-semibold rounded-xl hover:bg-brand-800 transition text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    قدّم أول طلب
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-6">
        {{ $leaveRequests->links() }}
    </div>
</x-app-layout>
