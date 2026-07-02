<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactoInteraccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacto_id',
        'tipo',
        'detalle',
        'fecha',
        'proyecto_id',
        'sistema_id',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'tipo' => 'string',
        ];
    }

    // Relaciones
    public function contacto(): BelongsTo
    {
        return $this->belongsTo(Contacto::class);
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
