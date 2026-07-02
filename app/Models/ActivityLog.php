<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    // Relaciones
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    // Scopes
    public function scopePorEvento($query, string $evento)
    {
        return $query->where('event', $evento);
    }

    public function scopePorModelo($query, string $modelo)
    {
        return $query->where('subject_type', $modelo);
    }

    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('causer_id', $userId);
    }
}
