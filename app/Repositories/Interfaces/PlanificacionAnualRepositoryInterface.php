<?php

namespace App\Repositories\Interfaces;

use App\Models\PlanificacionAnual;
use Illuminate\Database\Eloquent\Collection;

interface PlanificacionAnualRepositoryInterface
{
    public function getAll(?int $personaCargoCursadoId = null): Collection;
    public function findById(int $id): ?PlanificacionAnual;
    public function create(array $data): PlanificacionAnual;
    public function update(int $id, array $data): PlanificacionAnual;
    public function delete(int $id): bool;
}
