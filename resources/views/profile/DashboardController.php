<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan của nhà tuyển dụng.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $employer = Auth::user();

        // Lấy các công việc của nhà tuyển dụng, cùng với số lượng đơn ứng tuyển cho mỗi công việc
        $jobs = $employer->jobs()->withCount('applications')->latest()->paginate(10);

        return view('employer.dashboard', compact('employer', 'jobs'));
    }
}