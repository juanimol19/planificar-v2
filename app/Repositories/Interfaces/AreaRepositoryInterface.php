<?php

namespace App\Repositories\Interfaces;

use App\Models\Area;
use Illuminate\Database\Eloquent\Collection;

interface AreaRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Area;
    public function create(array $data): Area;
    public function update(int $id, array $data): Area;
    public function delete(int $id): bool;
}
