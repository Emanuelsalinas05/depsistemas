<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GithubInstallation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'provider',
        'installation_id',
        'account_login',
        'account_type',
        'metadata',
        'secret_ref',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    // Relaciones
    public function repositories(): HasMany
    {
        return $this->hasMany(GithubRepository::class);
    }

    public function webhookEvents(): HasMany
    {
        return $this->hasMany(GithubWebhookEvent::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
