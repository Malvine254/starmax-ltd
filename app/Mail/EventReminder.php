<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public string $reminderSubject,
        public string $reminderMessage,
        public string $eventUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->reminderSubject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.event-reminder');
    }
}
