<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard based on user role.
     *
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        // Chuyển hướng đến trang dashboard của Admin
        if ($user->isAdmin()) {
            $totalJobs = Job::count();
            $totalApplications = JobApplication::count();
            $totalUsers = User::count();
            return view('dashboard.admin', compact('totalJobs', 'totalApplications', 'totalUsers'));
        }

        // Chuyển hướng đến trang dashboard của Nhà tuyển dụng
        if ($user->isEmployer()) {
            $postedJobs = $user->jobs()->latest()->get();
            return view('dashboard.employer', compact('postedJobs'));
        }

        // Chuyển hướng đến trang dashboard của Ứng viên
        if ($user->isCandidate()) {
            $applications = $user->applications()->with('job')->latest()->take(5)->get();
            $savedJobs = $user->savedJobs()->with('pivot')->latest()->take(5)->get();
            return view('dashboard.candidate', compact('applications', 'savedJobs'));
        }

        // Fallback: Nếu người dùng không có vai trò, chuyển về trang chủ
        return redirect()->route('home');
    }
}