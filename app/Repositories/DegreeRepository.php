<?php

namespace App\Repositories;

use App\Models\Degree;
use App\Repositories\Interfaces\DegreeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DegreeRepository implements DegreeRepositoryInterface
{
    /**
     * Get all degrees with their faculties through programs.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Degree::with(['programs.faculty:id,name'])->get();
    }

    /**
     * Get a degree by id with its faculties through programs.
     *
     * @param int $id
     * @return Degree|null
     */
    public function getById(int $id): ?Degree
    {
        return Degree::with(['programs.faculty:id,name'])->find($id);
    }
}
