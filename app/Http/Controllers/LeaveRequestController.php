<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    // دالة عرض صفحة طلبات الإجازة
    public function index()
    {
        $user = auth()->user();

        // الأدمن يشوف كل الطلبات، الموظف يشوف طلباته فقط
        $leaveRequests = $user->role === 'admin'
            ? LeaveRequest::with('user')->latest()->get()
            : LeaveRequest::with('user')->where('user_id', $user->id)->latest()->get();

        return view('leave-requests.index', compact('leaveRequests'));
    }

    // دالة عرض صفحة إنشاء طلب إجازة
    public function create()
    {
        return view('leave-requests.create');
    }

    // دالة تخزين طلب الإجازة
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'تم تقديم طلب الإجازة بنجاح!');
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->update(['status' => $request->status]);

        $message = $request->status === 'approved' ? 'تمت الموافقة على الطلب!' : 'تم رفض الطلب.';

        return redirect()->route('leave-requests.index')->with('success', $message);
    }
}
