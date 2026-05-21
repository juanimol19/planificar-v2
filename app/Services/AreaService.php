<?php

namespace App\Services;

use App\Models\Area;
use App\Repositories\Interfaces\AreaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AreaService
{
    public function __construct(
        protected AreaRepositoryInterface $areaRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->areaRepository->getAll();
    }

    public function findById(int $id): ?Area
    {
        return $this->areaRepository->findById($id);
    }

    public function create(array $data): Area
    {
        return $this->areaRepository->create($data);
    }

    public function update(int $id, array $data): Area
    {
        return $this->areaRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->areaRepository->delete($id);
    }
}
