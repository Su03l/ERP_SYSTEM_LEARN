<x-app-layout>
    <x-slot name="header">التذاكر</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-brand-500 text-sm">إجمالي {{ $tickets->count() }} تذكرة</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            تذكرة جديدة
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
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">رقم التذكرة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الموضوع</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">مقدم الطلب</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">التاريخ</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider text-center">عرض</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-brand-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-mono font-semibold text-brand-900 bg-brand-100 px-2.5 py-1 rounded-lg">{{ $ticket->ticket_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-brand-900">{{ $ticket->subject }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-brand-950 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ mb_substr($ticket->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm text-brand-600">{{ $ticket->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <x-badge :status="$ticket->status" />
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-500">{{ $ticket->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('tickets.show', $ticket) }}" class="p-2 text-brand-400 hover:text-brand-900 hover:bg-brand-100 rounded-lg transition-colors inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                                <p class="text-brand-400 text-lg">لا توجد تذاكر حتى الآن</p>
                                <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-brand-950 text-white font-semibold rounded-xl hover:bg-brand-800 transition text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    أنشئ أول تذكرة
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
