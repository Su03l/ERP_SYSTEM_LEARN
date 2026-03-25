<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // 
    public function index()
    {
        $user = auth()->user();

        // الأدمن يشوف كل التذاكر، الموظف يشوف تذاكره فقط
        $tickets = $user->role === 'admin'
            ? Ticket::with('user')->latest()->get()
            : Ticket::with('user')->where('user_id', $user->id)->latest()->get();

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
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // توليد رقم تذكرة فريد
        $lastTicket = Ticket::latest('id')->first();
        $number = $lastTicket ? intval(substr($lastTicket->ticket_number, 4)) + 1 : 1;
        $ticketNumber = 'REQ-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Ticket::create([
            'ticket_number' => $ticketNumber,
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'تم إنشاء التذكرة بنجاح!');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('user');
        return view('tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->update(['status' => $request->status]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'تم تحديث حالة التذكرة!');
    }
}
