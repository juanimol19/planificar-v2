<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {}

    public function register(array $data): array
    {
        $user  = $this->authRepository->create($data);

        $user->assignRole(\Spatie\Permission\Models\Role::findByName($data['role'], 'api'));
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }

    public function login(array $data): array
    {
        $user = $this->authRepository->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'         => $user,
            'role'         => $user->getRoleNames()->first(),
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }
}