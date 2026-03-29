<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * القناة اللي بنبث فيها (بما أنها معلومات حساسة، بنخليها Private)
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-notifications'),
        ];
    }

    /**
     * البيانات اللي نبي الإدمن يستلمها في الجافاسكريبت
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->ticket->id,
            'subject' => $this->ticket->subject, // تأكد إنك غيرتها هنا لـ subject
            'employee_name' => $this->ticket->user->name,
            'created_at' => $this->ticket->created_at->diffForHumans(),
        ];
    }
}
