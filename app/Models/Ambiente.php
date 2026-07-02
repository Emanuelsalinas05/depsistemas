<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ambiente extends Model
{
    use HasFactory;

    protected $fillable = [
        'sistema_id',
        'nombre',
        'url',
        'servidor_id',
        'notas',
    ];

    protected function casts(): array
    {
        return [
            'nombre' => 'string',
        ];
    }

    // Relaciones
    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function servidor(): BelongsTo
    {
        return $this->belongsTo(Servidor::class);
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }
}
