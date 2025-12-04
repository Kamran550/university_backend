<?php

namespace App\Services;

use App\Models\Program;
use App\Repositories\Interfaces\ProgramRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProgramService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProgramRepositoryInterface $programRepository
    ) {
        //
    }

    /**
     * Get all programs.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->programRepository->getAll();
    }

    /**
     * Get a program by id.
     *
     * @param int $id
     * @return Program|null
     */
    public function getById(int $id): ?Program
    {
        return $this->programRepository->getById($id);
    }

    /**
     * Get programs filtered by degree_id and/or faculty_id.
     *
     * @param int|null $degreeId
     * @param int|null $facultyId
     * @return Collection
     */
    public function getFiltered(?int $degreeId = null, ?int $facultyId = null): Collection
    {
        return $this->programRepository->getFiltered($degreeId, $facultyId);
    }
}

