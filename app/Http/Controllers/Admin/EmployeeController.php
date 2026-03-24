<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // دالة إضافة موظف جديد
    public function store(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. إنشاء الموظف في قاعدة البيانات
        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee', // موظف عادي
        ]);

        // ملاحظة: هنا بنضيف الـ Job حق إرسال الإيميل لاحقاً!

        return redirect()->back()->with('success', 'تم إضافة الموظف بنجاح!');
    }
}
