<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    protected $table = 'cargos';

    protected $fillable = [
        'cargo',
    ];

    // Un cargo puede estar asignado a muchos persona_cargos
    public function personaCargos(): HasMany
    {
        return $this->hasMany(PersonaCargo::class, 'cargos_id');
    }
}
