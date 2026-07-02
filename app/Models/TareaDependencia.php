<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaDependencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_id',
        'depende_de_tarea_id',
    ];

    // Relaciones
    public function tarea(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function dependeDe(): BelongsTo
    {
        return $this->belongsTo(Tarea::class, 'depende_de_tarea_id');
    }
}
