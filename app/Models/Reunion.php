<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reunion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reuniones';

    protected $fillable = [
        'proyecto_id',
        'titulo',
        'fecha_inicio',
        'fecha_fin',
        'ubicacion',
        'descripcion',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'datetime',
            'fecha_fin' => 'datetime',
        ];
    }

    // Relaciones
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function minuta(): HasOne
    {
        return $this->hasOne(Minuta::class);
    }

    public function acuerdos(): HasMany
    {
        return $this->hasMany(Acuerdo::class);
    }

    public function asistentes(): HasMany
    {
        return $this->hasMany(ReunionAsistente::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin]);
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha_inicio', '>=', now());
    }
}
