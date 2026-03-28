<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // الحصول على المستخدم الحالي
        $user = auth()->user();

        //  تحديد مدة الكاش
        $statsTtl = now()->addMinutes(60); // 1 hour
        $listsTtl = now()->addMinutes(5); // 5 minutes

        if ($user->role === 'admin') {

            //  مستوى الإنتربرايز: تجميع الإحصائيات بقفل ذرّي (Atomic Lock)
            // القفل مدته 10 ثواني، وأي شخص يجي ورا الأول ينتظر 5 ثواني كحد أقصى لين يجهز الكاش
            $adminStats = Cache::lock('lock_admin_dashboard', 10)->block(5, function () use ($statsTtl) {

                return Cache::remember('admin_dashboard_stats', $statsTtl, function () {
                    return [
                        'totalEmployees' => User::where('role', 'employee')->count(), // جميع الموظفين
                        'openTickets' => Ticket::where('status', 'open')->count(), // جميع التذاكر المفتوحة
                        'totalTickets' => Ticket::count(), // جميع التذاكر
                        'pendingLeaves' => LeaveRequest::where('status', 'pending')->count(), // جميع طلبات الإجازة المعلقة
                        'totalLeaveRequests' => LeaveRequest::count(), // جميع طلبات الإجازة
                        'departments' => User::where('role', 'employee')->whereNotNull('department')->distinct('department')->count('department'), // جميع الأقسام
                    ];
                });
            });

            $recentEmployees = Cache::remember('admin_recent_employees', $listsTtl, fn() => User::where('role', 'employee')->latest()->take(5)->get()); // آخر 5 موظفين
            $recentTickets = Cache::remember('admin_recent_tickets', $listsTtl, fn() => Ticket::with('user')->latest()->take(5)->get());
            $recentLeaves = Cache::remember('admin_recent_leaves', $listsTtl, fn() => LeaveRequest::with('user')->latest()->take(5)->get());

            // دمج مصفوفة الإحصائيات مع القوائم وإرسالها للواجهة
            return view('dashboard', array_merge($adminStats, [
                'recentEmployees' => $recentEmployees,
                'recentTickets' => $recentTickets,
                'recentLeaves' => $recentLeaves
            ]));
        }


        // إحصائيات للموظف العادي
        $userStats = Cache::lock("lock_user_{$user->id}_stats", 10)->block(5, function () use ($user, $statsTtl) {
            return Cache::remember("user_{$user->id}_stats", $statsTtl, function () use ($user) {
                $user->loadCount([
                    'tickets as open_tickets_count' => fn($query) => $query->where('status', 'open'),
                    'tickets as closed_tickets_count' => fn($query) => $query->where('status', 'closed'),
                    'tickets as total_tickets_count',
                    'leaveRequests as pending_leaves_count' => fn($query) => $query->where('status', 'pending'),
                    'leaveRequests as approved_leaves_count' => fn($query) => $query->where('status', 'approved'),
                    'leaveRequests as total_leave_requests_count',
                ]);
                return $user;
            });
        });

        $recentTickets = Cache::remember("user_{$user->id}_recent_tickets", $listsTtl, fn() => Ticket::where('user_id', $user->id)->latest()->take(5)->get());
        $recentLeaves = Cache::remember("user_{$user->id}_recent_leaves", $listsTtl, fn() => LeaveRequest::where('user_id', $user->id)->latest()->take(5)->get());

        return view('dashboard', [
            'myOpenTickets' => $userStats->open_tickets_count,
            'myClosedTickets' => $userStats->closed_tickets_count,
            'myTotalTickets' => $userStats->total_tickets_count,
            'myPendingLeaves' => $userStats->pending_leaves_count,
            'myApprovedLeaves' => $userStats->approved_leaves_count,
            'myTotalLeaves' => $userStats->total_leave_requests_count,
            'recentTickets' => $recentTickets,
            'recentLeaves' => $recentLeaves,
            'recentEmployees' => collect(),
        ]);
    }
}
