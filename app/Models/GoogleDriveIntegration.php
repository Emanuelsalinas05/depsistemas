<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoogleDriveIntegration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'drive_folder_id',
        'drive_folder_name',
        'email',
        'secret_ref',
        'tipo',
        'sistema_id',
        'proyecto_id',
        'sync_documentos',
        'sync_bidireccional',
        'metadata',
        'last_sync_at',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'sync_documentos' => 'boolean',
            'sync_bidireccional' => 'boolean',
            'is_active' => 'boolean',
            'last_sync_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeConSincronizacion($query)
    {
        return $query->where('sync_documentos', true);
    }
}
