<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public string $eventUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        $eventTitle = $this->registration->event?->title ?? 'Starmax Event';

        return new Envelope(
            subject: 'Event registration confirmed: ' . $eventTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-registration-confirmation',
        );
    }
}
