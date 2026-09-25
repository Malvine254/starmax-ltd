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

    public array $programItems;

    public function __construct(
        public EventRegistration $registration,
        public string $reminderSubject,
        public string $reminderMessage,
        public ?string $eventUrl,
        public string $program,
    ) {
        $this->programItems = $this->parseProgramItems();
    }

    private function parseProgramItems(): array
    {
        return collect(preg_split('/\R/', trim($this->program)))
            ->map(function (string $line): array {
                if (preg_match('/^(.+\b(?:AM|PM))\s*:\s*(.+)$/i', trim($line), $matches)) {
                    return ['time' => trim($matches[1]), 'session' => trim($matches[2])];
                }

                return ['time' => '', 'session' => trim($line)];
            })
            ->filter(fn (array $item) => $item['session'] !== '')
            ->values()
            ->all();
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
