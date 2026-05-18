<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Persona extends Model
{
    use SoftDeletes;

    protected $table = 'personas';

    protected $fillable = [
        'apellidos',
        'nombres',
        'dni',
        'e-mail',
        'telefono',
        'direccion',
        'fecha_nacimiento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'deleted_at'       => 'datetime',
    ];

    // Una persona puede tener muchos persona_cargos
    public function personaCargos(): HasMany
    {
        return $this->hasMany(PersonaCargo::class, 'personas_id');
    }
}
