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
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(SiteEvent::class, 'site_event_id');
    }
}
