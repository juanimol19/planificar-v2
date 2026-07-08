<?php

namespace App\Repositories\Interfaces;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Collection;

interface PersonaRepositoryInterface
{
    public function getAll(): Collection;
    public function getDocentes(): Collection;
    public function findById(int $id): ?Persona;
    public function create(array $data): Persona;
    public function update(int $id, array $data): Persona;
    public function delete(int $id): bool;
}