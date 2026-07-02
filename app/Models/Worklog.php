<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worklog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tarea_id',
        'user_id',
        'fecha',
        'minutos',
        'descripcion',
        'source',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'source' => 'string',
        ];
    }

    // Relaciones
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    public function scopePorTarea($query, int $tareaId)
    {
        return $query->where('tarea_id', $tareaId);
    }
}
