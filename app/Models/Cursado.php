<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cursado extends Model
{
    protected $table = 'cursados';

    protected $fillable = [
        'anio_lectivo',
        'fecha_inicio',
        'fecha_fin',
        'cursos_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    // Un cursado pertenece a un curso
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'cursos_id');
    }

    // Un cursado puede tener muchos persona_cargo_cursado
    public function personaCargoCursados(): HasMany
    {
        return $this->hasMany(PersonaCargoCursado::class, 'cursados_id');
    }
}
