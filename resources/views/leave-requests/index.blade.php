<x-app-layout>
    <x-slot name="header">طلبات الإجازة</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-brand-500 text-sm">إجمالي {{ $leaveRequests->count() }} طلب</p>
        </div>
        <a href="{{ route('leave-requests.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            طلب إجازة جديد
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-brand-200 overflow-hidden animate-fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b border-brand-200 bg-brand-50">
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الموظف</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">من</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">إلى</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">المدة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">السبب</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الحالة</th>
                        @if(Auth::user()->role === 'admin')
                            <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider text-center">إجراء</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100">
                    @forelse($leaveRequests as $leave)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-brand-950 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ mb_substr($leave->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-brand-900">{{ $leave->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $leave->start_date->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $leave->end_date->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 text-sm text-brand-600">
                                {{ $leave->start_date->diffInDays($leave->end_date) + 1 }} يوم
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-600 truncate max-w-[200px]">{{ $leave->reason }}</td>
                            <td class="px-6 py-4">
                                <x-badge :status="$leave->status" />
                            </td>
                            @if(Auth::user()->role === 'admin')
                                <td class="px-6 py-4 text-center">
                                    @if($leave->status->value === 'pending')
                                        <div class="flex items-center justify-center gap-1">
                                            <form method="POST" action="{{ route('leave-requests.update', $leave) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="قبول">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('leave-requests.update', $leave) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="رفض">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-brand-400">—</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
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
</x-app-layout>
