<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'contenido',
        'is_private',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_private' => 'boolean',
        ];
    }

    // Relación polimórfica
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lecturas(): HasMany
    {
        return $this->hasMany(ComentarioLectura::class);
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
    public function scopePublicos($query)
    {
        return $query->where('is_private', false);
    }

    public function scopePrivados($query)
    {
        return $query->where('is_private', true);
    }
}
