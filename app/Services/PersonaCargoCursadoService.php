<?php

namespace App\Services;

use App\Models\PersonaCargoCursado;
use App\Repositories\Interfaces\PersonaCargoCursadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaCargoCursadoService
{
    public function __construct(
        protected PersonaCargoCursadoRepositoryInterface $personaCargoCursadoRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->personaCargoCursadoRepository->getAll();
    }

    public function findById(int $id): ?PersonaCargoCursado
    {
        return $this->personaCargoCursadoRepository->findById($id);
    }

    public function create(array $data): PersonaCargoCursado
    {
        return $this->personaCargoCursadoRepository->create($data);
    }

    public function update(int $id, array $data): PersonaCargoCursado
    {
        return $this->personaCargoCursadoRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->personaCargoCursadoRepository->delete($id);
    }
}
