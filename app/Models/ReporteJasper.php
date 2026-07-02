<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReporteJasper extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reportes_jasper';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'jrxml_path',
        'jasper_path',
        'output_default',
        'datasource',
        'parametros_schema',
        'version',
        'activo',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'output_default' => 'string',
            'parametros_schema' => 'array',
            'activo' => 'boolean',
        ];
    }

    // Relaciones
    public function ejecuciones(): HasMany
    {
        return $this->hasMany(ReporteEjecucion::class, 'reporte_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
