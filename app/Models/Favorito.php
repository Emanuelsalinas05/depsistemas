<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
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
}
