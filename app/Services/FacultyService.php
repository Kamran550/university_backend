<?php

namespace App\Services;

use App\Models\Faculty;
use App\Repositories\Interfaces\FacultyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FacultyService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected FacultyRepositoryInterface $facultyRepository
    ) {
        //
    }

    /**
     * Get all faculties.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->facultyRepository->getAll();
    }

    /**
     * Get a faculty by id.
     *
     * @param int $id
     * @return Faculty|null
     */
    public function getById(int $id): ?Faculty
    {
        return $this->facultyRepository->getById($id);
    }
}
