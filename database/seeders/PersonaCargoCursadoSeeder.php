<?php

namespace Database\Seeders;

use App\Models\PersonaCargoCursado;
use Illuminate\Database\Seeder;

class PersonaCargoCursadoSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            ['persona_cargos_id' => 1,  'cursados_id' => 1],
            ['persona_cargos_id' => 2,  'cursados_id' => 1],
            ['persona_cargos_id' => 3,  'cursados_id' => 2],
            ['persona_cargos_id' => 4,  'cursados_id' => 3],
            ['persona_cargos_id' => 5,  'cursados_id' => 4],
            ['persona_cargos_id' => 6,  'cursados_id' => 5],
            ['persona_cargos_id' => 7,  'cursados_id' => 6],
            ['persona_cargos_id' => 8,  'cursados_id' => 7],
            ['persona_cargos_id' => 9,  'cursados_id' => 8],
            ['persona_cargos_id' => 10, 'cursados_id' => 9],
        ];

        foreach ($registros as $data) {
            PersonaCargoCursado::create($data);
        }
    }
}
