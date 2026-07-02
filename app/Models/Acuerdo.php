<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Acuerdo extends Model
{
    use HasFactory;

    protected $fillable = [
        'reunion_id',
        'proyecto_id',
        'titulo',
        'detalle',
        'responsable_id',
        'fecha_compromiso',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'fecha_compromiso' => 'date',
            'estatus' => 'string',
        ];
    }

    // Relaciones
    public function reunion(): BelongsTo
    {
        return $this->belongsTo(Reunion::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function comentarios(): MorphMany
    {
        return $this->morphMany(Comentario::class, 'model');
    }

    // Scopes
    public function scopePorEstatus($query, string $estatus)
    {
        return $query->where('estatus', $estatus);
    }

    public function scopePendientes($query)
    {
        return $query->where('estatus', 'pendiente');
    }

    public function scopePorResponsable($query, int $userId)
    {
        return $query->where('responsable_id', $userId);
    }
}
