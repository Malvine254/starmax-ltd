<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'site_event_id',
        'name',
        'email',
        'phone',
        'company',
        'message',
        'status',
        'admin_notes',
        'read_at',
        'certificate_code',
        'certificate_issued_at',
        'certificate_emailed_at',
        'certificate_revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'certificate_issued_at' => 'datetime',
            'certificate_emailed_at' => 'datetime',
            'certificate_revoked_at' => 'datetime',
        ];
    }

    public function markAsRead(): void
    {
        if ($this->read_at === null) {
            $this->forceFill(['read_at' => now()])->save();
        }
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(SiteEvent::class, 'site_event_id');
    }
}
