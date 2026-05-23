<?php

namespace App\Repositories;

use App\Models\Area;
use App\Repositories\Interfaces\AreaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AreaRepository implements AreaRepositoryInterface
{
    public function getAll(): Collection
    {
        return Area::all();
    }

    public function findById(int $id): ?Area
    {
        return Area::find($id);
    }

    public function create(array $data): Area
    {
        return Area::create($data);
    }

    public function update(int $id, array $data): Area
    {
        $area = Area::findOrFail($id);
        $area->update($data);
        return $area;
    }

    public function delete(int $id): bool
    {
        $area = Area::findOrFail($id);
        return $area->delete();
    }
}
