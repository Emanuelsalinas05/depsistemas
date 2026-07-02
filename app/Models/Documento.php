<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sistema_id',
        'release_id',
        'tipo',
        'titulo',
        'estado',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
            'estado' => 'string',
        ];
    }

    // Relaciones
    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class);
    }

    public function release(): BelongsTo
    {
        return $this->belongsTo(Release::class);
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class, 'documento_etiqueta')
            ->withTimestamps();
    }

    public function versiones(): HasMany
    {
        return $this->hasMany(DocumentoVersion::class);
    }

    public function comentarios(): MorphMany
    {
        return $this->morphMany(Comentario::class, 'model');
    }

    public function checklists(): MorphMany
    {
        return $this->morphMany(Checklist::class, 'model');
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
    public function scopePublicados($query)
    {
        return $query->where('estado', 'publicado');
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
