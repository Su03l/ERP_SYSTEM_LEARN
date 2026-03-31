<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    private $departments = [
        'الموارد البشرية',
        'تقنية المعلومات',
        'المبيعات',
        'التسويق',
        'المالية والمحاسبة',
        'العمليات التشغيلية',
        'خدمة العملاء',
        'المشتريات والمخازن',
        'الشؤون القانونية',
        'الإدارة العامة'
    ];

    // دالة عرض جميع الموظفين
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['employee', 'supervisor'])
            ->withCount(['tickets', 'leaveRequests']);

        // إضافة منطق البحث
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm)
                  ->orWhere('employee_number', 'like', $searchTerm);
            });
        }

        $employees = $query->latest()->paginate(15);

        return view('employees.index', compact('employees'));
    }

    // دالة عرض صفحة إضافة موظف جديد
    public function create()
    {
        $departments = $this->departments;
        return view('employees.create', compact('departments'));
    }

    // دالة معالجة طلب إضافة موظف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_number' => 'nullable|string|max:50|unique:users,employee_number',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'job_title' => 'nullable|string',
            'department' => ['nullable', Rule::in($this->departments)],
            'salary' => 'nullable|numeric|min:0',
            'national_id' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'bank_iban' => 'nullable|string|max:34',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'role' => 'required|in:admin,supervisor,employee',
        ]);

        $role = $request->role;
        if (auth()->user()->role === 'supervisor' && $role !== 'employee') {
            $role = 'employee';
        }

        User::create([
            'name' => $request->name,
            'employee_number' => $request->employee_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'job_title' => $request->job_title,
            'department' => $request->department,
            'salary' => $request->salary,
            'national_id' => $request->national_id,
            'join_date' => $request->join_date,
            'bank_iban' => $request->bank_iban,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'role' => $role,
            'status' => 'active',
        ]);

        return redirect()->route('employees.index')->with('success', 'تم إضافة الموظف بنجاح!');
    }

    // دالة عرض صفحة تفاصيل الموظف
    public function show(User $employee)
    {
        $employee->load(['tickets', 'leaveRequests']);
        return view('employees.show', compact('employee'));
    }

    // دالة عرض صفحة تعديل بيانات الموظف
    public function edit(User $employee)
    {
        $departments = $this->departments;
        return view('employees.edit', compact('employee', 'departments'));
    }

    // دالة معالجة طلب تعديل بيانات الموظف
    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_number' => ['nullable', 'string', 'max:50', Rule::unique('users', 'employee_number')->ignore($employee->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'phone' => 'nullable|string',
            'job_title' => 'nullable|string',
            'department' => ['nullable', Rule::in($this->departments)],
            'status' => 'nullable|in:active,inactive',
            'salary' => 'nullable|numeric|min:0',
            'national_id' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'bank_iban' => 'nullable|string|max:34',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'role' => 'required|in:admin,supervisor,employee',
        ]);

        $data = $request->except('role');
        if (auth()->user()->role === 'admin') {
            $data['role'] = $request->role;
        }

        $employee->update($data);

        return redirect()->route('employees.show', $employee)->with('success', 'تم تحديث بيانات الموظف بنجاح!');
    }

    // دالة حذف الموظف
    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'تم حذف الموظف بنجاح!');
    }
}
