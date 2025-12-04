<?php

namespace App\Repositories;

use App\Models\Faculty;
use App\Repositories\Interfaces\FacultyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FacultyRepository implements FacultyRepositoryInterface
{
    /**
     * Get all faculties with their degrees through programs.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Faculty::with(['programs.degree:id,name'])->get();
    }

    /**
     * Get a faculty by id with its degrees through programs.
     *
     * @param int $id
     * @return Faculty|null
     */
    public function getById(int $id): ?Faculty
    {
        return Faculty::with(['programs.degree:id,name'])->find($id);
    }
}
