<?php

namespace App\Services;

use App\Models\SitRevista;
use App\Repositories\Interfaces\SitRevistaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SitRevistaService
{
    public function __construct(
        protected SitRevistaRepositoryInterface $sitRevistaRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->sitRevistaRepository->getAll();
    }

    public function findById(int $id): ?SitRevista
    {
        return $this->sitRevistaRepository->findById($id);
    }

    public function create(array $data): SitRevista
    {
        return $this->sitRevistaRepository->create($data);
    }

    public function update(int $id, array $data): SitRevista
    {
        return $this->sitRevistaRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->sitRevistaRepository->delete($id);
    }
}
