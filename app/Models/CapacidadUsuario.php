<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CapacidadUsuario extends Model
{
    use HasFactory;

    protected $table = 'capacidad_usuario';

    protected $fillable = [
        'user_id',
        'horas_por_dia',
        'dias_semana',
        'vigente_desde',
        'vigente_hasta',
    ];

    protected function casts(): array
    {
        return [
            'horas_por_dia' => 'decimal:2',
            'dias_semana' => 'array',
            'vigente_desde' => 'date',
            'vigente_hasta' => 'date',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeVigentes($query)
    {
        $now = now()->toDateString();
        return $query->where('vigente_desde', '<=', $now)
            ->where(function ($q) use ($now) {
                $q->whereNull('vigente_hasta')
                  ->orWhere('vigente_hasta', '>=', $now);
            });
    }
}
