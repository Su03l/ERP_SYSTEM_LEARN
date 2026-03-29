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

    //  عند تحديث طلب اجازة
    public function updated(LeaveRequest $leaveRequest): void
    {
        $this->clearDashboardCache($leaveRequest);
        event(new LeaveRequestUpdated($leaveRequest));
    }

    //  عند حذف طلب اجازة
    public function deleted(LeaveRequest $leaveRequest): void
    {
        $this->clearDashboardCache($leaveRequest);
    }

    //  مسح الكاش
    private function clearDashboardCache(LeaveRequest $leaveRequest): void
    {
        // مسح كاش الادمن
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_recent_leaves');

        Cache::forget("user_{$leaveRequest->user_id}_stats");
        Cache::forget("user_{$leaveRequest->user_id}_recent_leaves");
    }
}
