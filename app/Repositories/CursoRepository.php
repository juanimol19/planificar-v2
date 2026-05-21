<?php

namespace App\Repositories;

use App\Models\Curso;
use App\Repositories\Interfaces\CursoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CursoRepository implements CursoRepositoryInterface
{
    public function getAll(): Collection
    {
        return Curso::all();
    }

    public function findById(int $id): ?Curso
    {
        return Curso::find($id);
    }

    public function create(array $data): Curso
    {
        return Curso::create($data);
    }

    public function update(int $id, array $data): Curso
    {
        $curso = Curso::findOrFail($id);
        $curso->update($data);
        return $curso;
    }

    public function delete(int $id): bool
    {
        $curso = Curso::findOrFail($id);
        return $curso->delete();
    }
}
