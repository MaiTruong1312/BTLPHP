<?php
namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicantNotification extends Notification
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
        $applicant = $this->application->user;

        return [
            'applicant_id' => $applicant->id,
            'applicant_name' => $applicant->name,
            'job_id' => $job->id,
            'job_title' => $job->title,
            'message' => "<strong>{$applicant->name}</strong> đã ứng tuyển vào vị trí <strong>{$job->title}</strong>.",
            'url' => route('employer.applications.index'),
        ];
    }
}
