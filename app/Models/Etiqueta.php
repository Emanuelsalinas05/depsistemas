<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etiqueta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'color',
        'created_by',
    ];

    // Relaciones
    public function tareas(): BelongsToMany
    {
        return $this->belongsToMany(Tarea::class, 'tarea_etiqueta')
            ->withTimestamps();
    }

    public function documentos(): BelongsToMany
    {
        return $this->belongsToMany(Documento::class, 'documento_etiqueta')
            ->withTimestamps();
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
