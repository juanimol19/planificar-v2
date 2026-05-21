<?php

namespace App\Services;

use App\Models\PlanificacionDiaria;
use App\Repositories\Interfaces\PlanificacionDiariaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlanificacionDiariaService
{
    public function __construct(
        protected PlanificacionDiariaRepositoryInterface $planificacionDiariaRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->planificacionDiariaRepository->getAll();
    }

    public function findById(int $id): ?PlanificacionDiaria
    {
        return $this->planificacionDiariaRepository->findById($id);
    }

    public function create(array $data): PlanificacionDiaria
    {
        return $this->planificacionDiariaRepository->create($data);
    }

    public function update(int $id, array $data): PlanificacionDiaria
    {
        return $this->planificacionDiariaRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->planificacionDiariaRepository->delete($id);
    }
}
