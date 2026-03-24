<x-app-layout>
    <x-slot name="header">مسيرات الرواتب</x-slot>

    {{-- Top Bar --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-brand-500 text-sm">حدد الموظفين لإرسال مسيرات الرواتب عبر البريد الإلكتروني</p>
        </div>
        <button type="submit" form="sendBulkForm" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-950 text-white font-bold rounded-xl hover:bg-brand-800 transition-all duration-200 transform hover:scale-[1.01] active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
            إرسال مسيرات الرواتب
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 text-sm text-red-700 bg-red-50 border border-red-200 rounded-xl p-4 animate-fade-in">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="sendBulkForm" method="POST" action="{{ route('payroll.sendBulk') }}">
        @csrf
        {{-- Employees Table --}}
        <div class="bg-white rounded-xl border border-brand-200 overflow-hidden animate-fade-in">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="border-b border-brand-200 bg-brand-50">
                            <th class="px-6 py-4 text-xs font-bold text-brand-500 tracking-wider">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 text-brand-600 bg-gray-100 border-gray-300 rounded focus:ring-brand-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الموظف</th>
                            <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">المسمى الوظيفي</th>
                            <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">القسم</th>
                            <th class="px-6 py-4 text-xs font-bold text-brand-500 uppercase tracking-wider">الراتب المتوقع (تقريبي)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-brand-50 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="employees[]" value="{{ $employee->id }}" class="employee-checkbox w-4 h-4 text-brand-600 bg-gray-100 border-gray-300 rounded focus:ring-brand-500 cursor-pointer">
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
                                <td class="px-6 py-4 text-sm text-brand-600 font-mono" dir="ltr">{{ number_format($employee->salary ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-brand-200" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    <p class="text-brand-400 text-lg">لا يوجد موظفين نشطين حالياً لإرسال الرواتب لهم</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    {{-- Script for Select All Checkbox --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('selectAll');
            const employeeCheckboxes = document.querySelectorAll('.employee-checkbox');

            selectAllCheckbox.addEventListener('change', function () {
                employeeCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            employeeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else if (document.querySelectorAll('.employee-checkbox:checked').length === employeeCheckboxes.length) {
                        selectAllCheckbox.checked = true;
                    }
                });
            });
        });
    </script>
</x-app-layout>
