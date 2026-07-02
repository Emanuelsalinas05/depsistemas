<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteEjecucion extends Model
{
    use HasFactory;

    protected $table = 'reportes_ejecuciones';

    protected $fillable = [
        'reporte_id',
        'user_id',
        'parametros',
        'output',
        'status',
        'started_at',
        'finished_at',
        'archivo_path',
        'error_log',
        'runtime_ms',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'parametros' => 'array',
            'output' => 'string',
            'status' => 'string',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    // Relaciones
    public function reporte(): BelongsTo
    {
        return $this->belongsTo(ReporteJasper::class, 'reporte_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePorEstatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeExitosos($query)
    {
        return $query->where('status', 'success');
    }
}
