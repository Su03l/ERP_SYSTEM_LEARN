<?php

namespace App\Observers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;

class TicketObserver
{
    // تتنفذ تلقائياً عند إنشاء تذكرة جديدة
    public function created(Ticket $ticket): void
    {
        $this->clearDashboardCache($ticket);
    }

    // تتنفذ تلقائياً عند تحديث تذكرة (مثلاً تغيير حالتها من مفتوحة لمغلقة)
    public function updated(Ticket $ticket): void
    {
        $this->clearDashboardCache($ticket);
    }

    // تتنفذ تلقائياً عند حذف تذكرة
    public function deleted(Ticket $ticket): void
    {
        $this->clearDashboardCache($ticket);
    }

    // دالة التحديث المعمارية الجديدة
    private function clearDashboardCache(Ticket $ticket): void
    {
        // 1. مسح كاش الإدمن (المفتاح المجمّع الجديد + قائمة التذاكر الحديثة)
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_recent_tickets');

        // 2. مسح كاش الموظف صاحب التذكرة فقط (عشان إحصائياته تتحدث)
        Cache::forget("user_{$ticket->user_id}_stats");
        Cache::forget("user_{$ticket->user_id}_recent_tickets");
    }
}
