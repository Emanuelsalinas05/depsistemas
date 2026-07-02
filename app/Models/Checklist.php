<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'model_type',
        'model_id',
        'titulo',
        'created_by',
    ];

    // Relación polimórfica
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    // Relaciones
    public function items(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeCompletados($query)
    {
        return $query->whereHas('items', function ($q) {
            $q->where('done', true);
        });
    }
}
