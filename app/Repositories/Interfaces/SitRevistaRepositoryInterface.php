<?php

namespace App\Repositories\Interfaces;

use App\Models\SitRevista;
use Illuminate\Database\Eloquent\Collection;

interface SitRevistaRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?SitRevista;
    public function create(array $data): SitRevista;
    public function update(int $id, array $data): SitRevista;
    public function delete(int $id): bool;
}
