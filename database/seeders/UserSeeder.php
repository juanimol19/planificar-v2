<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $director = User::firstOrCreate(
            ['email' => 'director@colegio.com'],
            [
                'name'     => 'Director',
                'password' => Hash::make('123456789'),
            ]
        );

        $director->assignRole('director');
    }
}