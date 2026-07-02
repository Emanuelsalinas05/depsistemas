<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_integration_id',
        'tipo',
        'referencia_tipo',
        'referencia_id',
        'destinatario',
        'asunto',
        'contenido',
        'estado',
        'enviado_at',
        'error_message',
        'metadata',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'enviado_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    // Relaciones
    public function emailIntegration(): BelongsTo
    {
        return $this->belongsTo(EmailIntegration::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación polimórfica opcional
    public function referencia()
    {
        return $this->morphTo('referencia', 'referencia_tipo', 'referencia_id');
    }

    // Scopes
    public function scopeEnviados($query)
    {
        return $query->where('estado', 'enviado');
    }

    public function scopeFallidos($query)
    {
        return $query->where('estado', 'fallido');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
