<?php

namespace App\Events;

use App\Models\LeaveRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $leaveRequest;

    // 
    public function __construct(LeaveRequest $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    // هذا يحدد القناة التي سيتم البث عليها
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-notifications'),
        ];
    }

    // هذا يحدد البيانات التي سيتم بثها
    public function broadcastWith(): array
    {
        return [
            'id' => $this->leaveRequest->id,
            'subject' => $this->leaveRequest->reason,
            'employee_name' => $this->leaveRequest->user->name,
            'created_at' => $this->leaveRequest->created_at->diffForHumans(),
        ];
    }
}
