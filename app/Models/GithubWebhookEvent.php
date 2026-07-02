<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GithubWebhookEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'event_name',
        'delivery_id',
        'signature',
        'payload',
        'received_at',
        'processed_at',
        'status',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'received_at' => 'datetime',
            'processed_at' => 'datetime',
            'status' => 'string',
        ];
    }

    // Relaciones
    public function installation(): BelongsTo
    {
        return $this->belongsTo(GithubInstallation::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('status', 'received');
    }

    public function scopePorEvento($query, string $eventName)
    {
        return $query->where('event_name', $eventName);
    }
}
