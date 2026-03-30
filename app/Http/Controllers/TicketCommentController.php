<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use App\Notifications\TicketCommentNotification;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'status' => 'nullable|in:open,in_progress,closed',
        ]);

        $statusChangedTo = null;

        // فقط الإدمن من يمكنه تغيير الحالة أثناء الرد
        if (auth()->user()->role === 'admin' && $request->filled('status')) {
            if ($ticket->status->value !== $request->status) {
                $statusChangedTo = $request->status;
                $ticket->update(['status' => $request->status]);
            }
        }

        $comment = $ticket->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'status_change' => $statusChangedTo,
        ]);

        // إرسال الإشعار
        // إذا كان الكاتب هو الإدمن، نرسل الإشعار لصاحب التذكرة
        if (auth()->user()->role === 'admin') {
            $ticket->user->notify(new TicketCommentNotification($comment));
        } else {
            // إذا كان الكاتب هو המوظف، نرسل الإشعار للإدارة
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new TicketCommentNotification($comment));
        }

        return back()->with('success', 'تم إضافة الرد بنجاح!');
    }
}
