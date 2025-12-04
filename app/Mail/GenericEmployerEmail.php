<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GenericEmployerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $emailBody;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $body
     */
    public function __construct(string $subject, string $body)
    {
        $this->emailSubject = $subject;
        $this->emailBody = $body;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.employer.generic',
        );
    }
}