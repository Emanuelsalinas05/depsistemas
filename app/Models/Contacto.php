<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'rol',
        'area',
        'notas',
    ];

    // Relaciones
    public function interacciones(): HasMany
    {
        return $this->hasMany(ContactoInteraccion::class);
    }

    public function sistemas(): BelongsToMany
    {
        return $this->belongsToMany(Sistema::class, 'contacto_sistema')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 'contacto_proyecto')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    // Scopes
    public function scopePorRol($query, string $rol)
    {
        return $query->where('rol', $rol);
    }

    public function scopePorArea($query, string $area)
    {
        return $query->where('area', $area);
    }
}
