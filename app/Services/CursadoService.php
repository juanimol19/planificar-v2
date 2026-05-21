<?php

namespace App\Services;

use App\Models\Cursado;
use App\Repositories\Interfaces\CursadoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CursadoService
{
    public function __construct(
        protected CursadoRepositoryInterface $cursadoRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->cursadoRepository->getAll();
    }

    public function findById(int $id): ?Cursado
    {
        return $this->cursadoRepository->findById($id);
    }

    public function create(array $data): Cursado
    {
        return $this->cursadoRepository->create($data);
    }

    public function update(int $id, array $data): Cursado
    {
        return $this->cursadoRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->cursadoRepository->delete($id);
    }
}
