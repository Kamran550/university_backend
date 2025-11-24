<?php

namespace App\Repositories;

use App\Models\Faculty;
use App\Repositories\Interfaces\FacultyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FacultyRepository implements FacultyRepositoryInterface
{
    /**
     * Get all faculties.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Faculty::with('degrees:id,name')->get();
    }

    /**
     * Get a faculty by id.
     *
     * @param int $id
     * @return Faculty|null
     */
    public function getById(int $id): ?Faculty
    {
        return Faculty::with('degrees:id,name')->find($id);
    }
}
