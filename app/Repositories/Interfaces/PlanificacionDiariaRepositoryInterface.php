<?php

namespace App\Repositories\Interfaces;

use App\Models\PlanificacionDiaria;
use Illuminate\Database\Eloquent\Collection;

interface PlanificacionDiariaRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?PlanificacionDiaria;
    public function create(array $data): PlanificacionDiaria;
    public function update(int $id, array $data): PlanificacionDiaria;
    public function delete(int $id): bool;
}
