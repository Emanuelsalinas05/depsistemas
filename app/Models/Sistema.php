<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sistema extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'area_usuaria',
        'dueno_funcional',
        'criticidad',
        'estatus',
        'url_prod',
        'url_qa',
        'url_dev',
        'repositorio_url',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'criticidad' => 'string',
            'estatus' => 'string',
        ];
    }

    // Relaciones
    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }

    public function ambientes(): HasMany
    {
        return $this->hasMany(Ambiente::class);
    }

    public function tecnologias(): BelongsToMany
    {
        return $this->belongsToMany(Tecnologia::class, 'sistema_tecnologia')
            ->withPivot('version_usada')
            ->withTimestamps();
    }

    public function releases(): HasMany
    {
        return $this->hasMany(Release::class);
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }

    public function githubRepositories(): HasMany
    {
        return $this->hasMany(GithubRepository::class);
    }

    public function contactos(): BelongsToMany
    {
        return $this->belongsToMany(Contacto::class, 'contacto_sistema')
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
        return $query->where('estatus', 'activo');
    }

    public function scopePorCriticidad($query, string $criticidad)
    {
        return $query->where('criticidad', $criticidad);
    }

    public function scopePorArea($query, string $area)
    {
        return $query->where('area_usuaria', $area);
    }
}
