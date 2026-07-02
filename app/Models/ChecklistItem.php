<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'texto',
        'orden',
        'done',
        'done_by',
        'done_at',
    ];

    protected function casts(): array
    {
        return [
            'done' => 'boolean',
            'done_at' => 'datetime',
        ];
    }

    // Relaciones
    public function checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class);
    }

    public function doneBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'done_by');
    }

    // Scopes
    public function scopeCompletados($query)
    {
        return $query->where('done', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('done', false);
    }
}
