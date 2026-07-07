<?php

namespace App\Services;

use App\Models\PlanificacionAnual;
use App\Repositories\Interfaces\PlanificacionAnualRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlanificacionAnualService
{
    public function __construct(
        protected PlanificacionAnualRepositoryInterface $planificacionAnualRepository
    ) {}

public function getAll(?int $personaCargoCursadoId = null): Collection
{
    return $this->planificacionAnualRepository->getAll($personaCargoCursadoId);
}

    public function findById(int $id): ?PlanificacionAnual
    {
        return $this->planificacionAnualRepository->findById($id);
    }

    public function create(array $data): PlanificacionAnual
    {
        return $this->planificacionAnualRepository->create($data);
    }

    public function update(int $id, array $data): PlanificacionAnual
    {
        return $this->planificacionAnualRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->planificacionAnualRepository->delete($id);
    }
}
