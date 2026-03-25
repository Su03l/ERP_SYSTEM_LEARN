<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    // عرض الشاشة
    public function index()
    {
        // جلب جميع الموظفين
        $employees = User::where('role', 'employee')->where('status', 'active')->get();

        // عرض الشاشة
        return view('payroll.index', compact('employees'));
    }

    // إرسال مسيرات الرواتب
    public function sendBulk(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'employees' => 'required|array',
            'employees.*' => 'exists:users,id'
        ]);

        // جلب الموظفين
        $selectedEmployees = User::whereIn('id', $request->employees)->get();

        foreach ($selectedEmployees as $employee) {
            \App\Jobs\SendPayslipJob::dispatch($employee);
        }

        return redirect()->back()->with('success', 'تم استلام الطلب! جاري تجهيز وإرسال مسيرات الرواتب في الخلفية لـ ' . count($selectedEmployees) . ' موظف.');
    }
}
