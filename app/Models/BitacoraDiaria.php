<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitacoraDiaria extends Model
{
    use HasFactory;

    protected $table = 'bitacoras_diarias';

    protected $fillable = [
        'user_id',
        'fecha',
        'texto',
        'bloqueos',
        'proximo',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
