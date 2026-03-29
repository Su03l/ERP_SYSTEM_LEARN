<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //  التذكرة
    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    
    //  القناة اللي بنبث فيها (قناة صاحب التذكرة)
     
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->ticket->user_id),
        ];
    }

    /**
     * البيانات اللي نبي الموظف يستلمها في الجافاسكريبت
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'status' => $this->ticket->status->value ?? $this->ticket->status,
            'message' => 'تم تغيير حالة التذكرة: ' . $this->ticket->ticket_number,
        ];
    }
}
