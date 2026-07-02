<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'proyecto_id',
        'titulo',
        'descripcion',
        'tipo',
        'prioridad',
        'estado',
        'asignado_a',
        'fecha_inicio',
        'fecha_fin',
        'estimacion_horas',
        'progreso',
        'evidencia_url',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'estimacion_horas' => 'decimal:2',
            'progreso' => 'integer',
            'tipo' => 'string',
            'prioridad' => 'string',
            'estado' => 'string',
        ];
    }

    // Relaciones
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function asignadoA(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class, 'tarea_etiqueta')
            ->withTimestamps();
    }

    public function releases(): BelongsToMany
    {
        return $this->belongsToMany(Release::class, 'release_tarea')
            ->withTimestamps();
    }

    public function worklogs(): HasMany
    {
        return $this->hasMany(Worklog::class);
    }

    public function comentarios(): MorphMany
    {
        return $this->morphMany(Comentario::class, 'model');
    }

    public function checklists(): MorphMany
    {
        return $this->morphMany(Checklist::class, 'model');
    }

    public function dependencias(): BelongsToMany
    {
        return $this->belongsToMany(
            Tarea::class,
            'tarea_dependencias',
            'tarea_id',
            'depende_de_tarea_id'
        )->withTimestamps();
    }

    public function dependientes(): BelongsToMany
    {
        return $this->belongsToMany(
            Tarea::class,
            'tarea_dependencias',
            'depende_de_tarea_id',
            'tarea_id'
        )->withTimestamps();
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
    public function scopePorEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeAsignadasA($query, int $userId)
    {
        return $query->where('asignado_a', $userId);
    }

    public function scopePorPrioridad($query, string $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeEnRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
            ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin]);
    }

    // Validaciones de integridad
    public static function boot()
    {
        parent::boot();

        static::saving(function ($tarea) {
            // Validar fechas coherentes
            if ($tarea->fecha_inicio && $tarea->fecha_fin) {
                if ($tarea->fecha_fin < $tarea->fecha_inicio) {
                    throw new \InvalidArgumentException('La fecha de fin no puede ser anterior a la fecha de inicio.');
                }
            }

            // Validar progreso entre 0 y 100
            if ($tarea->progreso !== null) {
                if ($tarea->progreso < 0 || $tarea->progreso > 100) {
                    throw new \InvalidArgumentException('El progreso debe estar entre 0 y 100.');
                }
            }
        });
    }
}
