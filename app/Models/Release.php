<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sistema_id',
        'version',
        'fecha_release',
        'ambiente_objetivo',
        'changelog',
        'commit_ref',
        'riesgos',
        'rollback_plan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha_release' => 'date',
            'ambiente_objetivo' => 'string',
        ];
    }

    // Relaciones
    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function tareas(): BelongsToMany
    {
        return $this->belongsToMany(Tarea::class, 'release_tarea')
            ->withTimestamps();
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePorAmbiente($query, string $ambiente)
    {
        return $query->where('ambiente_objetivo', $ambiente);
    }

    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_release', [$fechaInicio, $fechaFin]);
    }
}
