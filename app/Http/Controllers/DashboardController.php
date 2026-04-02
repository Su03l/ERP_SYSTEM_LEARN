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

            $cacheKey = $user->role === 'admin' ? 'admin_dashboard_stats' : "supervisor_dashboard_stats_{$user->department}";
            $lockKey = $user->role === 'admin' ? 'lock_admin_dashboard' : "lock_supervisor_dashboard_{$user->department}";

            $adminStats = Cache::lock($lockKey, 10)->block(5, function () use ($statsTtl, $user, $cacheKey) {
                return Cache::remember($cacheKey, $statsTtl, function () use ($user) {

                    $employeeQuery = User::whereIn('role', ['employee', 'supervisor']);
                    $ticketQuery = Ticket::query();
                    $leaveQuery = LeaveRequest::query();

                    if ($user->role === 'supervisor') {
                        $employeeQuery->where('department', $user->department);
                        $ticketQuery->whereHas('user', fn($q) => $q->where('department', $user->department));
                        $leaveQuery->whereHas('user', fn($q) => $q->where('department', $user->department));
                    }

                    return [
                        'totalEmployees'    => (clone $employeeQuery)->count(),
                        'totalTickets'      => (clone $ticketQuery)->count(),
                        'openTickets'       => (clone $ticketQuery)->where('status', 'open')->count(),
                        'inProgressTickets' => (clone $ticketQuery)->where('status', 'in_progress')->count(),
                        'closedTickets'     => (clone $ticketQuery)->where('status', 'closed')->count(),
                        'totalLeaveRequests'=> (clone $leaveQuery)->count(),
                        'pendingLeaves'     => (clone $leaveQuery)->where('status', 'pending')->count(),
                        'approvedLeaves'    => (clone $leaveQuery)->where('status', 'approved')->count(),
                        'rejectedLeaves'    => (clone $leaveQuery)->where('status', 'rejected')->count(),
                        'departments'       => $user->role === 'admin' ? (clone $employeeQuery)->whereNotNull('department')->distinct('department')->count('department') : 1,
                    ];
                });
            });

            $recentEmployeesQuery = User::whereIn('role', ['employee', 'supervisor'])->latest()->take(5);
            $recentTicketsQuery   = Ticket::with('user')->latest()->take(7);
            $recentLeavesQuery    = LeaveRequest::with('user')->latest()->take(7);

            if ($user->role === 'supervisor') {
                $recentEmployeesQuery->where('department', $user->department);
                $recentTicketsQuery->whereHas('user', fn($q) => $q->where('department', $user->department));
                $recentLeavesQuery->whereHas('user', fn($q) => $q->where('department', $user->department));
            }

            $recentEmployees = $recentEmployeesQuery->get();
            $recentTickets = $recentTicketsQuery->get();
            $recentLeaves = $recentLeavesQuery->get();

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

        $recentTickets = Ticket::where('user_id', $user->id)->latest('id')->take(5)->get();
        $recentLeaves  = LeaveRequest::where('user_id', $user->id)->latest('id')->take(5)->get();

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
