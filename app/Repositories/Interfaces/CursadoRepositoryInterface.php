<?php

namespace App\Repositories\Interfaces;

use App\Models\Cursado;
use Illuminate\Database\Eloquent\Collection;

interface CursadoRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Cursado;
    public function create(array $data): Cursado;
    public function update(int $id, array $data): Cursado;
    public function delete(int $id): bool;
}
