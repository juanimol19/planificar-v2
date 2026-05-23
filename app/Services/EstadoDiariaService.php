<?php

namespace App\Services;

use App\Models\EstadoDiaria;
use App\Repositories\Interfaces\EstadoDiariaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EstadoDiariaService
{
    public function __construct(
        protected EstadoDiariaRepositoryInterface $estadoDiariaRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->estadoDiariaRepository->getAll();
    }

    public function findById(int $id): ?EstadoDiaria
    {
        return $this->estadoDiariaRepository->findById($id);
    }

    public function create(array $data): EstadoDiaria
    {
        return $this->estadoDiariaRepository->create($data);
    }

    public function update(int $id, array $data): EstadoDiaria
    {
        return $this->estadoDiariaRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->estadoDiariaRepository->delete($id);
    }
}
