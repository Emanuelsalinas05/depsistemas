<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relaciones
    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_miembros')
            ->withPivot('rol_en_proyecto', 'asignacion_activa')
            ->withTimestamps();
    }

    public function tareasAsignadas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'asignado_a');
    }

    public function worklogs(): HasMany
    {
        return $this->hasMany(Worklog::class);
    }

    public function capacidad(): HasMany
    {
        return $this->hasMany(CapacidadUsuario::class);
    }

    public function recordatorios(): HasMany
    {
        return $this->hasMany(Recordatorio::class);
    }

    public function bitacorasDiarias(): HasMany
    {
        return $this->hasMany(BitacoraDiaria::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class);
    }

    public function acuerdosResponsable(): HasMany
    {
        return $this->hasMany(Acuerdo::class, 'responsable_id');
    }

    public function reporteEjecuciones(): HasMany
    {
        return $this->hasMany(ReporteEjecucion::class);
    }

    public function iaGeneraciones(): HasMany
    {
        return $this->hasMany(IaGeneracion::class);
    }

    public function googleCalendarIntegrations(): HasMany
    {
        return $this->hasMany(GoogleCalendarIntegration::class);
    }

    public function googleDriveIntegrations(): HasMany
    {
        return $this->hasMany(GoogleDriveIntegration::class);
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class, 'created_by');
    }
}
