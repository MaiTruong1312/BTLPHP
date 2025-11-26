<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Hiển thị danh sách ứng viên cho một công việc.
     *
     * @param  \App\Models\Job $job
     * @return \Illuminate\View\View
     */
    public function index(Job $job)
    {
        // Đảm bảo nhà tuyển dụng chỉ có thể xem ứng viên cho công việc của chính họ
        if ($job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Tải các ứng dụng cùng với thông tin hồ sơ ứng viên
        $applications = $job->applications()->with('candidateProfile.user')->latest('applied_at')->paginate(15);

        return view('employer.applications.index', compact('job', 'applications'));
    }
}