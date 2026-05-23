<?php

namespace Database\Seeders;

use App\Models\SitRevista;
use Illuminate\Database\Seeder;

class SitRevistaSeeder extends Seeder
{
    public function run(): void
    {
        $revistas = ['Titular', 'Interino', 'Suplente'];

        foreach ($revistas as $revista) {
            SitRevista::create(['revista' => $revista]);
        }
    }
}
