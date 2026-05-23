<?php

namespace App\Repositories\Interfaces;

use App\Models\EstadoAnual;
use Illuminate\Database\Eloquent\Collection;

interface EstadoAnualRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?EstadoAnual;
    public function create(array $data): EstadoAnual;
    public function update(int $id, array $data): EstadoAnual;
    public function delete(int $id): bool;
}
