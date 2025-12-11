<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobLocation;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\ApplicationStatusUpdated;
use Illuminate\Support\Collection;

class ApplicationController extends Controller
{
    /**
     * Trang Admin > Manage Applications
     */
    public function index(Request $request)
    {
        $query = JobApplication::with([
            'job.category',
            'job.location',
            'job.employerProfile',
            'user',
        ]);

        // --- Search ---
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('job', function ($q2) use ($search) {
                    $q2->where('title', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('job.employerProfile', function ($q2) use ($search) {
                    $q2->where('company_name', 'like', '%' . $search . '%');
                });
            });
        }

        // --- Filter status ---
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // --- Filter category ---
        if ($categoryId = $request->get('category_id')) {
            $query->whereHas('job', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // --- Filter location ---
        if ($locationId = $request->get('location_id')) {
            $query->whereHas('job', function ($q) use ($locationId) {
                $q->where('location_id', $locationId);
            });
        }

        $applications = $query
            ->orderByDesc('applied_at')
            ->paginate(15)
            ->withQueryString();

        $categories = JobCategory::all();
        $locations  = JobLocation::all();

        return view('admin.applications.index', compact('applications', 'categories', 'locations'));
    }

    /**
     * Trang chi tiết 1 application + Timeline từ bảng notifications
     */
    public function show(JobApplication $application)
    {
        $application->load([
            'job.category',
            'job.location',
            'job.employerProfile',
            'user',
            'candidateProfile',
        ]);

        // 1) Log đầu tiên: ứng viên nộp đơn (dùng applied_at để trùng với phần Overview)
        $logs = collect();

        $logs->push((object) [
            'time'    => $application->applied_at ?? $application->created_at,
            'event'   => 'Application submitted',
            'details' => sprintf(
                'Ứng viên %s ứng tuyển vào %s',
                $application->user->name,
                $application->job->title
            ),
        ]);

        // 2) Các log đổi trạng thái: lấy từ bảng notifications (ApplicationStatusUpdated)
        $statusNotifications = DatabaseNotification::query()
            ->where('type', 'App\Notifications\ApplicationStatusUpdated')
            // lọc theo job_id (trong JSON data)
            ->where('data', 'like', '%"job_id":' . $application->job_id . '%')
            // và notifiable_id = ứng viên
            ->where('notifiable_id', $application->user_id)
            ->orderBy('created_at')
            ->get();

        $statusLogs = $statusNotifications->map(function (DatabaseNotification $notification) {
            $data = $notification->data; // cast sang array

            $event = 'Status updated';

            // tuỳ Notification đang lưu field nào
            $old = $data['old_status'] ?? null;
            $new = $data['new_status'] ?? ($data['status'] ?? null);

            if ($old && $new) {
                $detail = "Trạng thái: {$old} → {$new}";
            } elseif ($new) {
                $detail = "Trạng thái mới: {$new}";
            } else {
                $detail = '';
            }

            return (object) [
                'time'    => $notification->created_at,
                'event'   => $event,
                'details' => $detail,
            ];
        });

        // 3) Gộp lại & sort theo thời gian cho chắc
        $logs = $logs->merge($statusLogs)->sortBy('time')->values();

        return view('admin.applications.show', [
            'application' => $application,
            'logs'        => $logs,
        ]);
    }

    /**
     * Admin cập nhật status 1 application
     */
    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:applied,reviewing,interview,offered,rejected,withdrawn',
        ]);

        // Nếu sau này bạn muốn lưu cả old_status thì có thể giữ lại biến này
        // $oldStatus = $application->status;

        $application->status     = $request->input('status');
        $application->updated_at = now();
        $application->save();

        // Gửi notification để ghi log (giống phía employer)
        // Ở project của bạn constructor của ApplicationStatusUpdated
        // rất nhiều khả năng chỉ nhận 1 tham số: JobApplication
        $application->user->notify(new ApplicationStatusUpdated($application));

        return back()->with('success', 'Cập nhật trạng thái đơn ứng tuyển thành công.');
    }


    /**
     * Admin xoá 1 application
     */
    public function destroy(JobApplication $application)
    {
        $application->delete();

        return back()->with('success', 'Đã xóa đơn ứng tuyển thành công.');
    }
}
