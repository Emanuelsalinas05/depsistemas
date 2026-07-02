<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sistema_id',
        'nombre',
        'slug',
        'objetivo',
        'fecha_inicio',
        'fecha_fin',
        'estatus',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }

    // Relaciones
    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function miembros(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'proyecto_miembros')
            ->withPivot('rol_en_proyecto', 'asignacion_activa')
            ->withTimestamps();
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }

    public function reuniones(): HasMany
    {
        return $this->hasMany(Reunion::class);
    }

    public function acuerdos(): HasMany
    {
        return $this->hasMany(Acuerdo::class);
    }

    public function contactoInteracciones(): HasMany
    {
        return $this->hasMany(ContactoInteraccion::class);
    }

    public function contactos(): BelongsToMany
    {
        return $this->belongsToMany(Contacto::class, 'contacto_proyecto')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function googleDriveIntegrations(): HasMany
    {
        return $this->hasMany(GoogleDriveIntegration::class);
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
    public function scopeActivos($query)
    {
        return $query->whereIn('estatus', ['planeado', 'en_progreso']);
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->whereHas('miembros', function ($q) use ($userId) {
            $q->where('users.id', $userId)
              ->where('proyecto_miembros.asignacion_activa', true);
        });
    }

    // Validaciones de integridad
    public static function boot()
    {
        parent::boot();

        static::saving(function ($proyecto) {
            // Validar fechas coherentes
            if ($proyecto->fecha_inicio && $proyecto->fecha_fin) {
                if ($proyecto->fecha_fin < $proyecto->fecha_inicio) {
                    throw new \InvalidArgumentException('La fecha de fin no puede ser anterior a la fecha de inicio.');
                }
            }
        });

        static::deleting(function ($proyecto) {
            // Validar que no se elimine si tiene tareas activas
            if ($proyecto->tareas()->whereIn('estado', ['nuevo', 'en_curso', 'en_revision'])->exists()) {
                throw new \InvalidArgumentException('No se puede eliminar un proyecto con tareas activas.');
            }
        });
    }

    /**
     * Verificar que el proyecto tenga al menos un PM activo
     */
    public function tienePMActivo(): bool
    {
        return $this->miembros()
            ->where('proyecto_miembros.rol_en_proyecto', 'pm')
            ->where('proyecto_miembros.asignacion_activa', true)
            ->exists();
    }
}
