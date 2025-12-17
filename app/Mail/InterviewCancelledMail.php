<?php

namespace App\Mail;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $interview;

    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo hủy lịch phỏng vấn - ' . $this->interview->jobApplication->job->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.interview_cancelled',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}