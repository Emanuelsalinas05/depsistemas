<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoVersion extends Model
{
    use HasFactory;

    protected $table = 'documento_versiones';

    protected $fillable = [
        'documento_id',
        'version',
        'contenido',
        'archivo_path',
        'mermaid_source',
        'created_by',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // Relaciones
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
