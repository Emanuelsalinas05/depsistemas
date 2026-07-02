<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantillaDocumento extends Model
{
    use HasFactory;

    protected $table = 'plantillas_documento';

    protected $fillable = [
        'nombre',
        'tipo',
        'formato',
        'contenido_template',
        'version',
        'activa',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
            'formato' => 'string',
            'activa' => 'boolean',
        ];
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
