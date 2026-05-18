<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanificacionAnual extends Model
{
    protected $table = 'planificacion_anual';

    protected $fillable = [
        'fecha_presentacion',
        'aprendizajes_esperados',
        'saberes',
        'criterios',
        'bibliografia',
        'diagnostico',
        'areas_id',
        'persona_cargo_cursado_id',
        'tipo_planificacion',
    ];

    protected $casts = [
        'fecha_presentacion' => 'date',
    ];

    // Pertenece a un área
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'areas_id');
    }

    // Pertenece a un persona_cargo_cursado
    public function personaCargoCursado(): BelongsTo
    {
        return $this->belongsTo(PersonaCargoCursado::class, 'persona_cargo_cursado_id');
    }

    // Tiene muchos estados anuales
    public function estadosAnuales(): HasMany
    {
        return $this->hasMany(EstadoAnual::class, 'planificacion_anual_id');
    }
}
