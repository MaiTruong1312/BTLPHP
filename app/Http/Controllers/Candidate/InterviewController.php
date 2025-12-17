<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        // Lấy danh sách phỏng vấn của candidate hiện tại
        $interviews = Interview::whereHas('jobApplication', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->with(['jobApplication.job.employerProfile', 'interviewer'])
        ->orderBy('scheduled_at', 'desc')
        ->paginate(10);

        return view('candidates.interviews.index', compact('interviews'));
    }
}
