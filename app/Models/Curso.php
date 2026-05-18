<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'ciclo',
        'grado',
        'seccion',
        'turno',
    ];

    // Un curso puede tener muchos cursados (instancias anuales)
    public function cursados(): HasMany
    {
        return $this->hasMany(Cursado::class, 'cursos_id');
    }
}
