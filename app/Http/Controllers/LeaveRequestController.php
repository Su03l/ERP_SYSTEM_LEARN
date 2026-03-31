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

        // الأدمن يرى كل شيء، الموظف يرى طلباته فقط
        if ($user->role === 'employee') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'supervisor') {
            // المشرف يرى إجازات موظفي قسمه فقط وإجازاته هو
            $query->where(function($q) use ($user) {
                $q->whereHas('user', function($userQuery) use ($user) {
                    $userQuery->where('department', $user->department);
                })->orWhere('user_id', $user->id);
            });
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

        // الترتيب باستخدام ID لضمان ظهور أحدث الطلبات بشكل متسلسل (بسبب التواريخ العشوائية في التوليد)
        $leaveRequests = $query->latest('id')->paginate(15);

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

        // المشرف لا يعتمد إلا إجازات قسمه
        $user = auth()->user();
        if ($user->role === 'supervisor') {
            $leaveRequest->load('user');
            if ($leaveRequest->user->department !== $user->department) {
                abort(403, 'غير مصرح لك بتحديث إجازة لموظف من قسم آخر.');
            }
        }

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

        $user = auth()->user();
        // الموظف لا يرى إجازات غيره
        if ($user->role === 'employee' && $leaveRequest->user_id !== $user->id) {
            abort(403, 'غير مصرح لك بعرض هذه الإجازة.');
        }
        // المشرف يرى إجازات قسمه وإجازاته فقط
        if ($user->role === 'supervisor' && $leaveRequest->user->department !== $user->department && $leaveRequest->user_id !== $user->id) {
            abort(403, 'غير مصرح لك بعرض إجازة لموظف من قسم آخر.');
        }

        // Pass all possible LeaveStatus values to the view for the status update dropdown
        $statuses = LeaveStatus::cases();
        return view('leave-requests.show', compact('leaveRequest', 'statuses'));
    }
}
