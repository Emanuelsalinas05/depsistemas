<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailIntegration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo',
        'servidor',
        'puerto',
        'usuario',
        'secret_ref',
        'tls',
        'ssl',
        'configuracion',
        'notificaciones_activas',
        'recordatorios_activas',
        'reportes_activos',
        'plantillas',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tls' => 'boolean',
            'ssl' => 'boolean',
            'notificaciones_activas' => 'boolean',
            'recordatorios_activas' => 'boolean',
            'reportes_activos' => 'boolean',
            'is_active' => 'boolean',
            'configuracion' => 'array',
            'plantillas' => 'array',
        ];
    }

    // Relaciones
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
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

    public function scopeConNotificaciones($query)
    {
        return $query->where('notificaciones_activas', true);
    }
}
