<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCommentNotification extends Notification
{
    use Queueable;

    public $comment;

    // دالة البناء
    public function __construct(\App\Models\TicketComment $comment)
    {
        $this->comment = $comment;
    }

    // دالة تحديد قنوات الإشعارات
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // دالة تحويل الإشعار إلى مصفوفة
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->comment->ticket_id,
            'ticket_number' => $this->comment->ticket->ticket_number,
            'user_id' => $this->comment->user_id,
            'user_name' => $this->comment->user->name,
            'content' => $this->comment->content,
            'status_change' => $this->comment->status_change,
        ];
    }
}
