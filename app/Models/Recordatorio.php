<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recordatorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referencia_tipo',
        'referencia_id',
        'mensaje',
        'recordar_en',
        'enviado',
    ];

    protected function casts(): array
    {
        return [
            'recordar_en' => 'datetime',
            'enviado' => 'boolean',
        ];
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('enviado', false)
            ->where('recordar_en', '<=', now());
    }

    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
