<?php

namespace App\Repositories;

use App\Models\SitRevista;
use App\Repositories\Interfaces\SitRevistaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SitRevistaRepository implements SitRevistaRepositoryInterface
{
    public function getAll(): Collection
    {
        return SitRevista::all();
    }

    public function findById(int $id): ?SitRevista
    {
        return SitRevista::find($id);
    }

    public function create(array $data): SitRevista
    {
        return SitRevista::create($data);
    }

    public function update(int $id, array $data): SitRevista
    {
        $sitRevista = SitRevista::findOrFail($id);
        $sitRevista->update($data);
        return $sitRevista;
    }

    public function delete(int $id): bool
    {
        $sitRevista = SitRevista::findOrFail($id);
        return $sitRevista->delete();
    }
}
