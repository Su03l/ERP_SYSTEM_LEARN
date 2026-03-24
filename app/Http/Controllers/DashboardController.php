<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\LeaveRequest;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $totalEmployees = User::where('role', 'employee')->count();
            $openTickets = Ticket::where('status', 'open')->count();
            $pendingLeaves = LeaveRequest::where('status', 'pending')->count();
            $departments = User::where('role', 'employee')->whereNotNull('department')->distinct('department')->count('department');

            $recentEmployees = User::where('role', 'employee')->latest()->take(5)->get();
            $recentTickets = Ticket::with('user')->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalEmployees',
                'openTickets',
                'pendingLeaves',
                'departments',
                'recentEmployees',
                'recentTickets'
            ));
        }

        // إحصائيات للموظف العادي
        $myOpenTickets = Ticket::where('user_id', $user->id)->where('status', 'open')->count();
        $myClosedTickets = Ticket::where('user_id', $user->id)->where('status', 'closed')->count();
        $myPendingLeaves = LeaveRequest::where('user_id', $user->id)->where('status', 'pending')->count();
        $myApprovedLeaves = LeaveRequest::where('user_id', $user->id)->where('status', 'approved')->count();

        $recentTickets = Ticket::where('user_id', $user->id)->latest()->take(5)->get();
        $recentLeaves = LeaveRequest::where('user_id', $user->id)->latest()->take(5)->get();

        return view('dashboard', compact(
            'myOpenTickets',
            'myClosedTickets',
            'myPendingLeaves',
            'myApprovedLeaves',
            'recentTickets',
            'recentLeaves'
        ));
    }
}
