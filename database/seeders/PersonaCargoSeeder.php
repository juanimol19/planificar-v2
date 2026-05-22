<?php

namespace Database\Seeders;

use App\Models\PersonaCargo;
use Illuminate\Database\Seeder;

class PersonaCargoSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            ['personas_id' => 1,  'cargos_id' => 1,  'sit_revista_id' => 1],
            ['personas_id' => 2,  'cargos_id' => 4,  'sit_revista_id' => 2],
            ['personas_id' => 3,  'cargos_id' => 7,  'sit_revista_id' => 3],
            ['personas_id' => 4,  'cargos_id' => 2,  'sit_revista_id' => 3],
            ['personas_id' => 5,  'cargos_id' => 3,  'sit_revista_id' => 1],
            ['personas_id' => 6,  'cargos_id' => 5,  'sit_revista_id' => 2],
            ['personas_id' => 7,  'cargos_id' => 6,  'sit_revista_id' => 3],
            ['personas_id' => 8,  'cargos_id' => 8,  'sit_revista_id' => 2],
            ['personas_id' => 9,  'cargos_id' => 9,  'sit_revista_id' => 3],
            ['personas_id' => 10, 'cargos_id' => 10, 'sit_revista_id' => 1],
        ];

        foreach ($registros as $data) {
            PersonaCargo::create($data);
        }
    }
}
