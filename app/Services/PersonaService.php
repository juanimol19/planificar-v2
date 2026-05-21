<?php

namespace App\Services;

use App\Models\Persona;
use App\Repositories\Interfaces\PersonaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaService
{
    public function __construct(
        protected PersonaRepositoryInterface $personaRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->personaRepository->getAll();
    }

    public function findById(int $id): ?Persona
    {
        return $this->personaRepository->findById($id);
    }

    public function create(array $data): Persona
    {
        return $this->personaRepository->create($data);
    }

    public function update(int $id, array $data): Persona
    {
        return $this->personaRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->personaRepository->delete($id);
    }
}
