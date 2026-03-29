<?php

namespace App\Events;

use App\Models\LeaveRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestUpdated implements ShouldBroadcastNow
{
    //   
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $leaveRequest;

    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->leaveRequest->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->leaveRequest->id,
            'subject' => $this->leaveRequest->reason,
            'status' => $this->leaveRequest->status->value ?? $this->leaveRequest->status,
            'message' => 'تم تغيير حالة طلب الإجازة الخاص بك',
        ];
    }
}
