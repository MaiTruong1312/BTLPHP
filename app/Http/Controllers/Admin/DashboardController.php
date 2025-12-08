<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class DashboardController extends Controller
{
public function index()
    {
        // Statistics
        $stats = [
            'total_users'           => User::count(),
            'total_admins'          => User::where('role', 'admin')->count(),
            'total_employers'       => User::where('role', 'employer')->count(),
            'total_candidates'      => User::where('role', 'candidate')->count(),
            'total_jobs'            => Job::count(),
            'total_applications'    => JobApplication::count(),
            'new_users_last_week' => User::where('created_at', '>=', Carbon::now()->subWeek())->count(),
        ];

        // Data for charts or detailed breakdowns
        $jobs_by_status = Job::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Pending Jobs for approval
        $pending_jobs = Job::with('user', 'employerProfile')
            ->where('status', 'pending_approval')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent Users
        $recent_users = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'jobs_by_status', 'pending_jobs', 'recent_users'));
    }
}
