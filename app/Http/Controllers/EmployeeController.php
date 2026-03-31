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

    private function getDepartmentPrefix($department)
    {
        $prefixes = [
            'الموارد البشرية' => 'HR',
            'تقنية المعلومات' => 'IT',
            'المبيعات' => 'SLS',
            'التسويق' => 'MKT',
            'المالية والمحاسبة' => 'FIN',
            'العمليات التشغيلية' => 'OPS',
            'خدمة العملاء' => 'CS',
            'المشتريات والمخازن' => 'PR',
            'الشؤون القانونية' => 'LGL',
            'الإدارة العامة' => 'GM',
        ];

        return $prefixes[$department] ?? 'EMP';
    }

    // دالة عرض جميع الموظفين
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['employee', 'supervisor'])
            ->withCount(['tickets', 'leaveRequests']);

        // تقييد المشرف برؤية موظفي قسمه فقط
        if (auth()->user()->role === 'supervisor') {
            $query->where('department', auth()->user()->department);
        }

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
        $department = $request->department;

        // المشرف لا يستطيع تعيين أدمن، ولا يستطيع إضافة موظف في قسم آخر
        if (auth()->user()->role === 'supervisor') {
            if ($role !== 'employee') {
                $role = 'employee';
            }
            $department = auth()->user()->department; // إجبار الموظف الجديد أن يكون في نفس قسم المشرف
        }

        $employeeNumber = $request->employee_number;
        if (empty($employeeNumber) && $department) {
            $prefix = $this->getDepartmentPrefix($department);
            // البحث عن آخر رقم موظف في هذا القسم لتوليد رقم جديد
            $lastUser = User::where('department', $department)
                            ->where('employee_number', 'like', $prefix . '-%')
                            ->orderBy('id', 'desc')
                            ->first();

            $nextNumber = 1;
            if ($lastUser && preg_match('/-(\d+)$/', $lastUser->employee_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }
            $employeeNumber = $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        User::create([
            'name' => $request->name,
            'employee_number' => $employeeNumber,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'job_title' => $request->job_title,
            'department' => $department,
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
        if (auth()->user()->role === 'supervisor' && $employee->department !== auth()->user()->department) {
            abort(403, 'غير مصرح لك بعرض بيانات موظف من قسم آخر.');
        }
        $employee->load(['tickets', 'leaveRequests']);
        return view('employees.show', compact('employee'));
    }

    // دالة عرض صفحة تعديل بيانات الموظف
    public function edit(User $employee)
    {
        if (auth()->user()->role === 'supervisor' && $employee->department !== auth()->user()->department) {
            abort(403, 'غير مصرح لك بتعديل بيانات موظف من قسم آخر.');
        }
        $departments = $this->departments;
        return view('employees.edit', compact('employee', 'departments'));
    }

    // دالة معالجة طلب تعديل بيانات الموظف
    public function update(Request $request, User $employee)
    {
        if (auth()->user()->role === 'supervisor' && $employee->department !== auth()->user()->department) {
            abort(403, 'غير مصرح لك بتعديل بيانات موظف من قسم آخر.');
        }

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

        // المشرف لا يستطيع تغيير الصلاحية، ولا يستطيع نقل الموظف لقسم آخر
        if (auth()->user()->role === 'admin') {
            $data['role'] = $request->role;
        } elseif (auth()->user()->role === 'supervisor') {
            $data['department'] = auth()->user()->department; // منع نقل الموظف لقسم آخر
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
