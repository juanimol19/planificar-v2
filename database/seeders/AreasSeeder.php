<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['area' => 'Matemáticas',        'tipo' => 'Ciencias Exactas'],
            ['area' => 'Lengua y Literatura', 'tipo' => 'Humanidades'],
            ['area' => 'Ciencias Sociales',   'tipo' => 'Humanidades'],
            ['area' => 'Biología',            'tipo' => 'Ciencias Naturales'],
            ['area' => 'Física',              'tipo' => 'Ciencias Naturales'],
            ['area' => 'Química',             'tipo' => 'Ciencias Naturales'],
            ['area' => 'Historia',            'tipo' => 'Humanidades'],
            ['area' => 'Geografía',           'tipo' => 'Humanidades'],
            ['area' => 'Educación Física',    'tipo' => 'Salud y Bienestar'],
            ['area' => 'Arte',                'tipo' => 'Humanidades'],
        ];

        foreach ($areas as $data) {
            Area::create($data);
        }
    }
}
