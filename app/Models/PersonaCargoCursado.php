<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonaCargoCursado extends Model
{
    protected $table = 'persona_cargo_cursado';

    protected $fillable = [
        'persona_cargos_id',
        'cursados_id',
    ];

    // Pertenece a un persona_cargo
    public function personaCargo(): BelongsTo
    {
        return $this->belongsTo(PersonaCargo::class, 'persona_cargos_id');
    }

    // Pertenece a un cursado
    public function cursado(): BelongsTo
    {
        return $this->belongsTo(Cursado::class, 'cursados_id');
    }

    // Tiene muchas planificaciones anuales
    public function planificacionesAnuales(): HasMany
    {
        return $this->hasMany(PlanificacionAnual::class, 'persona_cargo_cursado_id');
    }

    // Tiene muchas planificaciones diarias
    public function planificacionesDiarias(): HasMany
    {
        return $this->hasMany(PlanificacionDiaria::class, 'persona_cargo_cursado_id');
    }
}
