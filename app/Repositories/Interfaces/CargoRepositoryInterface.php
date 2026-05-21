<?php

namespace App\Repositories\Interfaces;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Collection;

interface CargoRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Cargo;
    public function create(array $data): Cargo;
    public function update(int $id, array $data): Cargo;
    public function delete(int $id): bool;
}
