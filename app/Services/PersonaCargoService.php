<?php

namespace App\Services;

use App\Models\PersonaCargo;
use App\Repositories\Interfaces\PersonaCargoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonaCargoService
{
    public function __construct(
        protected PersonaCargoRepositoryInterface $personaCargoRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->personaCargoRepository->getAll();
    }

    public function findById(int $id): ?PersonaCargo
    {
        return $this->personaCargoRepository->findById($id);
    }

    public function create(array $data): PersonaCargo
    {
        return $this->personaCargoRepository->create($data);
    }

    public function update(int $id, array $data): PersonaCargo
    {
        return $this->personaCargoRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->personaCargoRepository->delete($id);
    }
}
