<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->latest()->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
            'job_title' => 'nullable|string',
            'department' => 'nullable|string',
            'salary' => 'nullable|numeric|min:0',
            'national_id' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'bank_iban' => 'nullable|string|max:34',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'role' => 'required|in:admin,employee',
        ]);

        User::create([
            'name' => $request->name,
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
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('employees.index')->with('success', 'تم إضافة الموظف بنجاح!');
    }

    public function show(User $employee)
    {
        $employee->load(['tickets', 'leaveRequests']);
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'phone' => 'nullable|string',
            'job_title' => 'nullable|string',
            'department' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'salary' => 'nullable|numeric|min:0',
            'national_id' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'bank_iban' => 'nullable|string|max:34',
            'address' => 'nullable|string|max:500',
            'emergency_contact' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'role' => 'required|in:admin,employee',
        ]);

        $employee->update($request->only([
            'name', 'email', 'phone', 'job_title', 'department', 'status',
            'salary', 'national_id', 'join_date', 'bank_iban', 'address',
            'emergency_contact', 'gender', 'birth_date', 'role'
        ]));

        return redirect()->route('employees.show', $employee)->with('success', 'تم تحديث بيانات الموظف بنجاح!');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'تم حذف الموظف بنجاح!');
    }
}
