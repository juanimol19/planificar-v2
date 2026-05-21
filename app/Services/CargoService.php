<?php

namespace App\Services;

use App\Models\Cargo;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CargoService
{
    public function __construct(
        protected CargoRepositoryInterface $cargoRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->cargoRepository->getAll();
    }

    public function findById(int $id): ?Cargo
    {
        return $this->cargoRepository->findById($id);
    }

    public function create(array $data): Cargo
    {
        return $this->cargoRepository->create($data);
    }

    public function update(int $id, array $data): Cargo
    {
        return $this->cargoRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->cargoRepository->delete($id);
    }
}
