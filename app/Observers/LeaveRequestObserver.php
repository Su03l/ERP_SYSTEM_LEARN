<?php

namespace App\Observers;

use App\Events\LeaveRequestCreated;
use App\Events\LeaveRequestUpdated;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Cache;

class LeaveRequestObserver
{
    //  عند انشاء طلب اجازة
    public function created(LeaveRequest $leaveRequest)
    {
        Cache::forget('admin_dashboard_stats');
        event(new LeaveRequestCreated($leaveRequest));
    }

    public function updated(LeaveRequest $leaveRequest): void
    {
        $this->clearDashboardCache($leaveRequest);
        event(new LeaveRequestUpdated($leaveRequest));
    }

    public function deleted(LeaveRequest $leaveRequest): void
    {
        $this->clearDashboardCache($leaveRequest);
    }

    private function clearDashboardCache(LeaveRequest $leaveRequest): void
    {
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_recent_leaves');

        Cache::forget("user_{$leaveRequest->user_id}_stats");
        Cache::forget("user_{$leaveRequest->user_id}_recent_leaves");
    }
}
