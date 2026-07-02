<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servidor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo',
        'proveedor',
        'hostname',
        'ip',
        'so',
        'cpu',
        'ram_gb',
        'disco_gb',
        'ubicacion',
        'secret_ref',
        'estatus',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
            'estatus' => 'string',
        ];
    }

    // Relaciones
    public function ambientes(): HasMany
    {
        return $this->hasMany(Ambiente::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estatus', 'activo');
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
