<?php

namespace App\Repositories\Interfaces;

use App\Models\EstadoDiaria;
use Illuminate\Database\Eloquent\Collection;

interface EstadoDiariaRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?EstadoDiaria;
    public function create(array $data): EstadoDiaria;
    public function update(int $id, array $data): EstadoDiaria;
    public function delete(int $id): bool;
}
