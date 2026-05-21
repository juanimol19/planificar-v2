<?php

namespace App\Repositories\Interfaces;

use App\Models\PersonaCargoCursado;
use Illuminate\Database\Eloquent\Collection;

interface PersonaCargoCursadoRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?PersonaCargoCursado;
    public function create(array $data): PersonaCargoCursado;
    public function update(int $id, array $data): PersonaCargoCursado;
    public function delete(int $id): bool;
}
