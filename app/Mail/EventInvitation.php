<?php

namespace App\Mail;

use App\Models\SiteEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 60;

    public string $invitationSubject;

    public string $invitationMessage;

    public ?string $eventUrl;

    public function __construct(public SiteEvent $event, public array $recipient, string $subject, string $message)
    {
        $this->eventUrl = $event->onlineEventUrl();
        $fields = [
            '{{name}}' => $recipient['name'], '{{email}}' => $recipient['email'],
            '{{phone}}' => $recipient['phone'], '{{company}}' => $recipient['company'],
            '{{event}}' => $event->title, '{{date}}' => $event->starts_at?->format('D, d M Y, g:i A') ?? 'To be confirmed',
            '{{location}}' => $event->location ?: 'To be confirmed', '{{event_url}}' => $this->eventUrl ?? '',
        ];
        $this->invitationSubject = str_replace(["\r", "\n"], ' ', strtr($subject, $fields));
        $this->invitationMessage = strtr($message, $fields);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->invitationSubject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.event-invitation');
    }
}
