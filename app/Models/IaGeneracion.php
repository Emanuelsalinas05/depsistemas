<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class IaGeneracion extends Model
{
    use HasFactory;

    protected $table = 'ia_generaciones';

    protected $fillable = [
        'prompt_id',
        'model_type',
        'model_id',
        'user_id',
        'input_context',
        'output_text',
        'meta',
        'status',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'status' => 'string',
        ];
    }

    // Relación polimórfica opcional
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    // Relaciones
    public function prompt(): BelongsTo
    {
        return $this->belongsTo(IaPrompt::class, 'prompt_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeExitosos($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFallidos($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
