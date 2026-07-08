<?php

namespace App\Services;

use App\Models\Curso;
use App\Repositories\Interfaces\CursoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CursoService
{
    public function __construct(
        protected CursoRepositoryInterface $cursoRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->cursoRepository->getAll();
    }

    public function findById(int $id): ?Curso
    {
        return $this->cursoRepository->findById($id);
    }

    public function create(array $data): Curso
    {
        return $this->cursoRepository->create($data);
    }

    public function update(int $id, array $data): Curso
    {
        return $this->cursoRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->cursoRepository->delete($id);
    }

    public function getCursosConDocente(): Collection
    {
        return $this->cursoRepository->getCursosConDocente();
    }
}