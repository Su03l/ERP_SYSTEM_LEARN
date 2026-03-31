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
        $user = auth()->user();
        $statsTtl = now()->addMinutes(60);

        if ($user->role === 'admin' || $user->role === 'supervisor') {

            $adminStats = Cache::lock('lock_admin_dashboard', 10)->block(5, function () use ($statsTtl) {
                return Cache::remember('admin_dashboard_stats', $statsTtl, function () {
                    return [
                        'totalEmployees'    => User::whereIn('role', ['employee', 'supervisor'])->count(),
                        'totalTickets'      => Ticket::count(),
                        'openTickets'       => Ticket::where('status', 'open')->count(),
                        'inProgressTickets' => Ticket::where('status', 'in_progress')->count(),
                        'closedTickets'     => Ticket::where('status', 'closed')->count(),
                        'totalLeaveRequests'=> LeaveRequest::count(),
                        'pendingLeaves'     => LeaveRequest::where('status', 'pending')->count(),
                        'approvedLeaves'    => LeaveRequest::where('status', 'approved')->count(),
                        'rejectedLeaves'    => LeaveRequest::where('status', 'rejected')->count(),
                        'departments'       => User::whereIn('role', ['employee', 'supervisor'])->whereNotNull('department')->distinct('department')->count('department'),
                    ];
                });
            });

            $recentEmployees = User::whereIn('role', ['employee', 'supervisor'])->latest()->take(5)->get();
            $recentTickets   = Ticket::with('user')->latest()->take(7)->get();
            $recentLeaves    = LeaveRequest::with('user')->latest()->take(7)->get();

            return view('dashboard', array_merge($adminStats, [
                'recentEmployees' => $recentEmployees,
                'recentTickets'   => $recentTickets,
                'recentLeaves'    => $recentLeaves,
            ]));
        }

        // Employee Dashboard
        $userStatsData = Cache::lock("lock_user_{$user->id}_stats", 10)->block(5, function () use ($user, $statsTtl) {
            return Cache::remember("user_{$user->id}_stats", $statsTtl, function () use ($user) {
                $user->loadCount([
                    'tickets as open_tickets_count'   => fn($q) => $q->where('status', 'open'),
                    'tickets as closed_tickets_count'  => fn($q) => $q->where('status', 'closed'),
                    'tickets as total_tickets_count',
                    'leaveRequests as pending_leaves_count'  => fn($q) => $q->where('status', 'pending'),
                    'leaveRequests as approved_leaves_count' => fn($q) => $q->where('status', 'approved'),
                    'leaveRequests as total_leave_requests_count',
                ]);
                return [
                    'open_tickets_count'          => $user->open_tickets_count,
                    'closed_tickets_count'         => $user->closed_tickets_count,
                    'total_tickets_count'          => $user->total_tickets_count,
                    'pending_leaves_count'         => $user->pending_leaves_count,
                    'approved_leaves_count'        => $user->approved_leaves_count,
                    'total_leave_requests_count'   => $user->total_leave_requests_count,
                ];
            });
        });

        $userStats = (object) $userStatsData;

        $recentTickets = Ticket::where('user_id', $user->id)->latest()->take(5)->get();
        $recentLeaves  = LeaveRequest::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard', [
            'myOpenTickets'   => $userStats->open_tickets_count,
            'myClosedTickets' => $userStats->closed_tickets_count,
            'myTotalTickets'  => $userStats->total_tickets_count,
            'myPendingLeaves' => $userStats->pending_leaves_count,
            'myApprovedLeaves'=> $userStats->approved_leaves_count,
            'myTotalLeaves'   => $userStats->total_leave_requests_count,
            'recentTickets'   => $recentTickets,
            'recentLeaves'    => $recentLeaves,
        ]);
    }
}
