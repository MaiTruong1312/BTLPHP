<?php
// app/Notifications/ApplicationStatusUpdated.php
namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    protected $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $job = $this->application->job;
        $status = $this->application->status;

        return [
            'job_id' => $job->id,
            'job_title' => $job->title,
            'status' => $status,
            'message' => "Hồ sơ của bạn cho vị trí <strong>{$job->title}</strong> đã được cập nhật trạng thái thành: <strong>{$status}</strong>.",
            'url' => route('jobs.show', $job->slug),
        ];
    }
}
