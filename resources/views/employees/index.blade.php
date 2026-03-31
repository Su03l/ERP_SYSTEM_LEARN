<x-app-layout>
    <x-slot name="header">الموظفين</x-slot>

    {{-- Top Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-brand-500 text-sm">إجمالي {{ $employees->total() }} موظف</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('employees.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" placeholder="بحث بالاسم أو الجوال..."
                       value="{{ request('search') }}"
                       class="border-brand-200 rounded-xl px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    بحث
                </button>
            </form>
            <a href="{{ route('employees.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                إضافة موظف
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    {{-- Employees Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden animate-fade-in">
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b border-brand-100 bg-white">
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">رقم الموظف</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">الموظف</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">المسمى الوظيفي</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">القسم</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">الجوال</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-xs font-bold text-brand-400 uppercase tracking-wider text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-brand-50/50 transition-all duration-200 group">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded-lg font-mono">#{{ $employee->id }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-brand-950 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        {{ mb_substr($employee->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-brand-900">{{ $employee->name }}</p>
                                        <p class="text-xs text-brand-400">{{ $employee->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $employee->job_title ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-brand-600">{{ $employee->department ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-brand-600 font-mono" dir="ltr">{{ $employee->phone ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <x-badge :status="$employee->status ?? 'active'" />
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('employees.show', $employee) }}" class="p-2 text-brand-400 hover:text-brand-900 hover:bg-brand-100 rounded-lg transition-colors" title="عرض">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="p-2 text-brand-400 hover:text-brand-900 hover:bg-brand-100 rounded-lg transition-colors" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-brand-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                                <p class="text-brand-400 text-lg">لا يوجد موظفين حتى الآن</p>
                                <a href="{{ route('employees.create') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-brand-950 text-white font-semibold rounded-xl hover:bg-brand-800 transition text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                    أضف أول موظف
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
        {{ $employees->links() }}
    </div>
</x-app-layout>
