<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tecnologia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'version_recomendada',
        'website',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
        ];
    }

    // Relaciones
    public function sistemas(): BelongsToMany
    {
        return $this->belongsToMany(Sistema::class, 'sistema_tecnologia')
            ->withPivot('version_usada')
            ->withTimestamps();
    }

    // Scopes
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
