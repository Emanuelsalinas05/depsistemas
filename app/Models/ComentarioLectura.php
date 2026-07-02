<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComentarioLectura extends Model
{
    use HasFactory;

    protected $fillable = [
        'comentario_id',
        'user_id',
        'leido_en',
    ];

    protected function casts(): array
    {
        return [
            'leido_en' => 'datetime',
        ];
    }

    // Relaciones
    public function comentario(): BelongsTo
    {
        return $this->belongsTo(Comentario::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
