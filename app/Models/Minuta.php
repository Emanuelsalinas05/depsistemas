<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Minuta extends Model
{
    use HasFactory;

    protected $fillable = [
        'reunion_id',
        'resumen',
        'decisiones',
        'created_by',
    ];

    // Relaciones
    public function reunion(): BelongsTo
    {
        return $this->belongsTo(Reunion::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
