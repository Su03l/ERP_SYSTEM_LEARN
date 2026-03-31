<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //  عرض جميع التذاكر
    public function index(Request $request)
    {
        //  جلب المستخدم الحالي
        $user = auth()->user();

        //  جلب جميع التذاكر
        $query = Ticket::with('user');

        //  الأدمن يرى كل شيء، الموظف يرى تذاكره فقط
        if ($user->role === 'employee') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'supervisor') {
            // المشرف يرى تذاكر موظفي قسمه فقط وتذاكره هو
            $query->where(function($q) use ($user) {
                $q->whereHas('user', function($userQuery) use ($user) {
                    $userQuery->where('department', $user->department);
                })->orWhere('user_id', $user->id); // عشان لو المشرف فتح تذكرة خاصة فيه
            });
        }

        //  تصفية حسب الحالة
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        //  البحث في التذاكر
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ticket_number', 'like', $searchTerm)
                  ->orWhere('subject', 'like', $searchTerm);
            });
        }

        // جلب اخر 15 تذكرة
        // الترتيب باستخدام ID لضمان ظهور أحدث الطلبات بشكل متسلسل (بسبب التواريخ العشوائية في التوليد)
        $tickets = $query->latest('id')->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    //  عرض صفحة إنشاء تذكرة
    public function create()
    {
        return view('tickets.create');
    }

    //  تخزين تذكرة جديدة
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp4,mov|max:20480',
        ]);

        // توليد رقم تذكرة فريد
        $lastTicket = Ticket::latest('id')->first();
        $number = $lastTicket ? intval(substr($lastTicket->ticket_number, 4)) + 1 : 1;
        $ticketNumber = 'REQ-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        $data = [
            'ticket_number' => $ticketNumber,
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'open',
        ];

        // تخزين المرفق
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('tickets/attachments', 'public');
        }

        // إنشاء تذكرة
        Ticket::create($data);

        // إعادة توجيه المستخدم إلى صفحة التذاكر
        return redirect()->route('tickets.index')->with('success', 'تم إنشاء التذكرة بنجاح!');
    }

    //  عرض صفحة التذكرة
    public function show(Ticket $ticket)
    {
        //  تحميل بيانات المستخدم
        $ticket->load('user');

        $user = auth()->user();
        // الموظف لا يرى تذاكر غيره
        if ($user->role === 'employee' && $ticket->user_id !== $user->id) {
            abort(403, 'غير مصرح لك بعرض هذه التذكرة.');
        }
        // المشرف يرى تذاكر قسمه وتذاكره فقط
        if ($user->role === 'supervisor' && $ticket->user->department !== $user->department && $ticket->user_id !== $user->id) {
            abort(403, 'غير مصرح لك بعرض تذكرة لموظف من قسم آخر.');
        }

        return view('tickets.show', compact('ticket'));
    }

    //  تحديث حالة التذكرة
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        // المشرف لا يغلق إلا تذاكر قسمه
        $user = auth()->user();
        if ($user->role === 'supervisor') {
            $ticket->load('user');
            if ($ticket->user->department !== $user->department) {
                abort(403, 'غير مصرح لك بتحديث تذكرة لموظف من قسم آخر.');
            }
        }

        $ticket->update(['status' => $request->status]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'تم تحديث حالة التذكرة!');
    }
}
