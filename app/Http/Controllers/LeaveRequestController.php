<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Enums\LeaveStatus; // Import the LeaveStatus enum

class LeaveRequestController extends Controller
{
    // دالة عرض صفحة طلبات الإجازة
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = LeaveRequest::with('user');

        // الأدمن والمشرف يشوفون كل الطلبات، الموظف يشوف طلباته فقط
        if ($user->role !== 'admin' && $user->role !== 'supervisor') {
            $query->where('user_id', $user->id);
        }

        // فلترة بالحالة
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // إضافة منطق البحث
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('reason', 'like', $searchTerm)
                  ->orWhere('type', 'like', $searchTerm)
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', $searchTerm);
                  });
            });
        }

        $leaveRequests = $query->latest()->paginate(15);

        // Pass all possible LeaveStatus values to the view for the filter dropdown
        $statuses = LeaveStatus::cases();

        return view('leave-requests.index', compact('leaveRequests', 'statuses'));
    }

    // دالة عرض صفحة إنشاء طلب إجازة
    public function create()
    {
        return view('leave-requests.create');
    }

    // دالة تخزين طلب الإجازة
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'type' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp4,mov|max:10240',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => LeaveStatus::PENDING, // Use enum
        ];

        // معالجة المرفق إذا وُجد
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('leaves/attachments', 'public');
        }

        // إنشاء طلب الإجازة
        LeaveRequest::create($data);

        // إعادة توجيه المستخدم إلى صفحة طلبات الإجازة
        return redirect()->route('leave-requests.index')->with('success', 'تم تقديم طلب الإجازة بنجاح!');
    }

    // دالة تحديث حالة طلب الإجازة
    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'status' => ['required', 'in:' . implode(',', array_column(LeaveStatus::cases(), 'value'))], // Validate against enum values
        ]);

        // تحديث حالة طلب الإجازة
        $leaveRequest->update(['status' => $request->status]);

        // رسالة للمستخدم
        $message = $request->status === LeaveStatus::APPROVED->value ? 'تمت الموافقة على الطلب!' : 'تم رفض الطلب.';

        // إعادة توجيه المستخدم إلى صفحة طلبات الإجازة
        return redirect()->route('leave-requests.index')->with('success', $message);
    }

    // دالة عرض تفاصيل طلب الإجازة
    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load('user');
        // Pass all possible LeaveStatus values to the view for the status update dropdown
        $statuses = LeaveStatus::cases();
        return view('leave-requests.show', compact('leaveRequest', 'statuses'));
    }
}
