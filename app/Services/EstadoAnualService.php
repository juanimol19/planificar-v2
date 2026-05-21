<?php

namespace App\Services;

use App\Models\EstadoAnual;
use App\Repositories\Interfaces\EstadoAnualRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EstadoAnualService
{
    public function __construct(
        protected EstadoAnualRepositoryInterface $estadoAnualRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->estadoAnualRepository->getAll();
    }

    public function findById(int $id): ?EstadoAnual
    {
        return $this->estadoAnualRepository->findById($id);
    }

    public function create(array $data): EstadoAnual
    {
        return $this->estadoAnualRepository->create($data);
    }

    public function update(int $id, array $data): EstadoAnual
    {
        return $this->estadoAnualRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->estadoAnualRepository->delete($id);
    }
}
