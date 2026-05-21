<?php

namespace App\Repositories\Interfaces;

use App\Models\PersonaCargo;
use Illuminate\Database\Eloquent\Collection;

interface PersonaCargoRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?PersonaCargo;
    public function create(array $data): PersonaCargo;
    public function update(int $id, array $data): PersonaCargo;
    public function delete(int $id): bool;
}
