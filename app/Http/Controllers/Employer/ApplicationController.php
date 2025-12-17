<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobApplicationHistory;
use App\Notifications\ApplicationStatusUpdated; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericEmployerEmail;
use App\Models\Job;

class ApplicationController extends Controller
{
    public function showApplicants(Job $job)
    {
        $this->authorize('view', $job);
        $applications = $job->applications()->with('user')->latest()->paginate(10);
        $templates = auth()->user()->emailTemplates()->get();
        return view('jobs.applicants', compact('job', 'applications', 'templates'));
    }

    public function showEmailForm(int $id)
    {
        $application = JobApplication::with(['user', 'job.user', 'job.employerProfile'])->findOrFail($id);
        $this->authorize('view', $application->job);
        $templates = auth()->user()->emailTemplates()->get();

        return view('employer.applications.send-email', compact('application', 'templates'));
    }

    public function sendEmail(Request $request, int $id)
    {
        $application = JobApplication::with(['user', 'job.user', 'job.employerProfile'])->findOrFail($id);

        // Đảm bảo nhà tuyển dụng có quyền xem đơn ứng tuyển này
        $this->authorize('view', $application->job);

        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $subject = $request->input('subject');
        $body = $request->input('body');

        // Thay thế các biến trong nội dung email
        $subject = str_replace('{candidate_name}', $application->user->name, $subject);
        $subject = str_replace('{job_title}', $application->job->title, $subject);
        $subject = str_replace('{company_name}', $application->job->employerProfile->company_name ?? $application->job->user->name, $subject);
        $body = str_replace('{candidate_name}', $application->user->name, $body);
        $body = str_replace('{job_title}', $application->job->title, $body);
        $body = str_replace('{company_name}', $application->job->employerProfile->company_name ?? $application->job->user->name, $body);

        Mail::to($application->user->email)->send(new GenericEmployerEmail($subject, $body));

        return redirect()->route('employer.applications.index')->with('success', 'Email đã được gửi thành công tới ' . $application->user->name);
    }

    public function index(Request $request)
    {
        $employer = Auth::user();
        
        // Lấy danh sách công việc của nhà tuyển dụng để hiển thị trong bộ lọc
        $jobs = Job::where('user_id', $employer->id)->orderBy('title')->get();

        $query = JobApplication::with(['job', 'user', 'candidateProfile'])
            ->whereHas('job', function ($q) use ($employer) {
                $q->where('user_id', $employer->id);
            });

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        
        // Thêm logic lọc theo công việc
        if ($jobId = $request->get('job_id')) {
            $query->where('job_id', $jobId);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('job', function ($q) use ($search) {
                    $q->where('title', 'like', '%'.$search.'%');
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            });
        }

        $applications = $query->orderByDesc('applied_at')->paginate(15)->withQueryString();

        $templates = $employer->emailTemplates()->get();

        return view('employer.index', compact('applications', 'templates', 'jobs'));
    }

    public function show($id)
    {
        $application = JobApplication::with(['user', 'job', 'candidateProfile'])->findOrFail($id);

        // Check authorization: Ensure the job belongs to the logged-in employer
        if ($application->job->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Lấy lịch sử thay đổi
        $histories = JobApplicationHistory::where('job_application_id', $id)
            ->with('user')
            ->latest()
            ->get();

        return view('employer.applications.show', compact('application', 'histories'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:reviewing,interview,offered,rejected',
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        $application = JobApplication::with('job')->findOrFail($id);
        if ($application->job->user_id !== Auth::id()) {
            throw new AuthorizationException;
        }

        $oldStatus = $application->status;
        $application->status = $request->input('status');
        
        // Lưu lý do từ chối nếu có
        if ($application->status === 'rejected') {
            $application->rejection_reason = $request->input('rejection_reason');
        }

        $application->save();

        // Ghi log lịch sử
        JobApplicationHistory::create([
            'job_application_id' => $application->id,
            'user_id' => Auth::id(),
            'from_status' => $oldStatus,
            'to_status' => $application->status,
            'note' => $request->input('rejection_reason') ? 'Reason: ' . $request->input('rejection_reason') : 'Status updated manually by employer.',
        ]);

        // Gửi thông báo cho ứng viên
        $candidate = $application->user;
        $candidate->notify(new ApplicationStatusUpdated($application));

        return back()->with('success', 'Cập nhật trạng thái đơn ứng tuyển thành công.');
    }

    public function updateNotes(Request $request, int $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $application = JobApplication::with('job')->findOrFail($id);
        if ($application->job->user_id !== Auth::id()) {
            throw new AuthorizationException;
        }

        $application->notes = $request->input('notes');
        $application->save();

        return back()->with('success', 'Ghi chú đã được cập nhật.');
    }

    public function destroy(int $id)
    {
        $application = JobApplication::with('job')->findOrFail($id);

        if ($application->job->user_id !== Auth::id()) {
            throw new AuthorizationException;
        }

        $application->delete();

        return back()->with('success', 'Đã xóa đơn ứng tuyển thành công.');
    }
}