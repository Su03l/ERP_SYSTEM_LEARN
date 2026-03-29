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

        $query = Ticket::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('ticket_number', 'like', $searchTerm)
                  ->orWhere('subject', 'like', $searchTerm);
            });
        }

        $tickets = $query->latest()->paginate(15);

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
        ]);

        // توليد رقم تذكرة فريد
        $lastTicket = Ticket::latest('id')->first();
        $number = $lastTicket ? intval(substr($lastTicket->ticket_number, 4)) + 1 : 1;
        $ticketNumber = 'REQ-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        //  إنشاء تذكرة
        Ticket::create([
            'ticket_number' => $ticketNumber,
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'open',
        ]);

        //  إعادة توجيه المستخدم إلى صفحة التذاكر
        return redirect()->route('tickets.index')->with('success', 'تم إنشاء التذكرة بنجاح!');
    }

    //  عرض صفحة التذكرة
    public function show(Ticket $ticket)
    {
        //  تحميل بيانات المستخدم
        $ticket->load('user');
        return view('tickets.show', compact('ticket'));
    }

    //  تحديث حالة التذكرة
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->update(['status' => $request->status]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'تم تحديث حالة التذكرة!');
    }
}
