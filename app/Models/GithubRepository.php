<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GithubRepository extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'installation_id',
        'repo_id',
        'full_name',
        'default_branch',
        'sistema_id',
        'proyecto_id',
        'is_active',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'metadata' => 'array',
        ];
    }

    // Relaciones
    public function installation(): BelongsTo
    {
        return $this->belongsTo(GithubInstallation::class);
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }
}
