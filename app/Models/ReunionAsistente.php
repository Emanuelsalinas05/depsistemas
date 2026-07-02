<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReunionAsistente extends Model
{
    use HasFactory;

    protected $fillable = [
        'reunion_id',
        'user_id',
        'nombre_externo',
        'email_externo',
    ];

    // Relaciones
    public function reunion(): BelongsTo
    {
        return $this->belongsTo(Reunion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
