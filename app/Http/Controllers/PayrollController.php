<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    // عرض الشاشة
    public function index(Request $request)
    {
        $query = User::where('role', 'employee')->where('status', 'active');

        // إضافة منطق البحث
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('job_title', 'like', $searchTerm) // Assuming job_title might be relevant for payroll search
                  ->orWhere('department', 'like', $searchTerm); // Assuming department might be relevant for payroll search
            });
        }

        // جلب جميع الموظفين مع التصفح
        $employees = $query->latest()->paginate(15);

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

        // إرسال مسيرات الرواتب
        foreach ($selectedEmployees as $employee) {
            \App\Jobs\SendPayslipJob::dispatch($employee);
        }

        // رسالة نجاح
        return redirect()->back()->with('success', 'تم استلام الطلب! جاري تجهيز وإرسال مسيرات الرواتب في الخلفية لـ ' . count($selectedEmployees) . ' موظف.');
    }
}
