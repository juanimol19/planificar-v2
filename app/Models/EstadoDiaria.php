<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstadoDiaria extends Model
{
    protected $table = 'estados_diaria';

protected $fillable = [
    'estado',
    'fecha',
    'observaciones',
    'planificacion_diaria_id',
];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Pertenece a una planificación diaria
    public function planificacionDiaria(): BelongsTo
    {
        return $this->belongsTo(PlanificacionDiaria::class, 'planificacion_diaria_id');
    }
}
