<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteEvent extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'format',
        'location',
        'starts_at',
        'ends_at',
        'excerpt',
        'description',
        'program',
        'cta_label',
        'cta_url',
        'event_url',
        'certificate_signer_name',
        'certificate_signer_title',
        'certificate_message',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'site_event_id');
    }

    public function onlineEventUrl(): ?string
    {
        return strcasecmp(trim((string) $this->format), 'Online') === 0 && filled($this->event_url)
            ? $this->event_url
            : null;
    }

    public static function defaultProgram(): string
    {
        return "9:00 AM - 10:00 AM: Arrival and registration\n"
            ."10:00 AM - 11:00 AM: Opening session\n"
            ."11:00 AM - 12:00 PM: Main program\n"
            ."12:00 PM - 1:00 PM: Closing and networking";
    }

    public static function defaultCertificateMessage(): string
    {
        return 'for successfully completing :event:company. Awarded in recognition of participation, commitment, and successful completion.';
    }

    public function certificateMessageHtml(?string $company = null): string
    {
        $template = trim((string) $this->certificate_message) ?: self::defaultCertificateMessage();
        $safeTemplate = e($template);
        $companyText = trim((string) $company) !== '' ? ', representing '.trim((string) $company) : '';

        return str_replace(
            [':event', ':company'],
            ['<strong>'.e($this->title).'</strong>', e($companyText)],
            $safeTemplate
        );
    }
}
