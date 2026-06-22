<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Persona::create([
            'user_id'          => $user->id,
            'nombres'          => $data['name'],
            'apellidos'        => '',
            'dni'              => null,
            'e-mail'           => null,
            'telefono'         => '',
            'direccion'        => '',
            'fecha_nacimiento' => null,
        ]);

        return $user;
    }
}