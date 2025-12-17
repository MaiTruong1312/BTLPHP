<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\JobApplicationHistory;
use App\Mail\InterviewUpdatedMail;
use App\Mail\InterviewCancelledMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InterviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Interview::with(['jobApplication.job', 'jobApplication.user', 'jobApplication.candidateProfile'])
            ->where('interviewer_id', auth()->id());

        // Tìm kiếm theo tên ứng viên, email hoặc tên công việc
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jobApplication', function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('job', function ($j) use ($search) {
                    $j->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Lọc theo trạng thái, loại, ngày
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }

        $interviews = $query->orderBy('scheduled_at', 'desc')->paginate(10)->withQueryString();

        // Thống kê số lượng phỏng vấn sắp tới trong tuần này (từ hiện tại đến hết Chủ Nhật)
        $upcomingInterviewsCount = Interview::where('interviewer_id', auth()->id())
            ->where('status', 'scheduled')
            ->whereBetween('scheduled_at', [Carbon::now(), Carbon::now()->endOfWeek()])
            ->count();

        return view('employer.interviews.index', compact('interviews', 'upcomingInterviewsCount'));
    }

    public function show(Interview $interview)
    {
        // Đảm bảo chỉ người tạo lịch mới được xem/sửa
        if ($interview->interviewer_id !== auth()->id()) {
            abort(403);
        }

        $interview->load(['jobApplication.job', 'jobApplication.user', 'jobApplication.candidateProfile', 'evaluation']);

        return view('employer.interviews.show', compact('interview'));
    }

    public function update(Request $request, Interview $interview)
    {
        if ($interview->interviewer_id !== auth()->id()) {
            abort(403);
        }

        $rules = [
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15',
            'type' => 'required|in:online,offline',
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ];

        // Nếu trạng thái là cancelled, bắt buộc phải có lý do
        if ($request->status === 'cancelled') {
            $rules['cancellation_reason'] = 'required|string|max:500';
        }

        $validated = $request->validate($rules);

        // Lưu lại giá trị cũ để so sánh
        $originalScheduledAt = $interview->scheduled_at;
        $originalLocation = $interview->location;
        $originalStatus = $interview->status;

        $interview->update($validated);

        // 1. Xử lý khi HỦY lịch
        if ($interview->status === 'cancelled' && $originalStatus !== 'cancelled') {
            // Cập nhật trạng thái đơn ứng tuyển về 'reviewing'
            $oldAppStatus = $interview->jobApplication->status;
            $interview->jobApplication->update(['status' => 'reviewing']);

            // Ghi log lịch sử
            JobApplicationHistory::create([
                'job_application_id' => $interview->jobApplication->id,
                'user_id' => auth()->id(),
                'from_status' => $oldAppStatus,
                'to_status' => 'reviewing',
                'note' => 'Status reverted automatically due to interview cancellation.',
            ]);

            $interview->load(['jobApplication.user', 'jobApplication.job.employerProfile']);
            Mail::to($interview->jobApplication->user->email)->send(new InterviewCancelledMail($interview));
            
            return back()->with('success', 'Interview cancelled, application status reverted to reviewing, and candidate notified.');
        }

        // Nếu thời gian hoặc địa điểm thay đổi, gửi email thông báo
        if ($interview->status !== 'cancelled' && ($interview->scheduled_at->ne($originalScheduledAt) || $interview->location !== $originalLocation)) {
            // Load quan hệ để lấy email ứng viên và tên công ty
            $interview->load(['jobApplication.user', 'jobApplication.job.employerProfile']);
            
            Mail::to($interview->jobApplication->user->email)->send(new InterviewUpdatedMail($interview));
            
            return back()->with('success', 'Interview details updated and candidate notified via email!');
        }

        return back()->with('success', 'Interview details updated successfully!');
    }
}