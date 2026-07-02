<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IaPrompt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo',
        'prompt_template',
        'version',
        'activo',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
            'activo' => 'boolean',
        ];
    }

    // Relaciones
    public function generaciones(): HasMany
    {
        return $this->hasMany(IaGeneracion::class, 'prompt_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
