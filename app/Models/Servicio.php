<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'ambiente_id',
        'tipo',
        'nombre',
        'version',
        'endpoint',
        'secret_ref',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
        ];
    }

    // Relaciones
    public function ambiente(): BelongsTo
    {
        return $this->belongsTo(Ambiente::class);
    }
}
