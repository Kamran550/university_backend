<?php

namespace App\Repositories;

use App\Models\Program;
use App\Repositories\Interfaces\ProgramRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProgramRepository implements ProgramRepositoryInterface
{
    /**
     * Get all programs with their degree and faculty.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Program::with(['degree:id,name', 'faculty:id,name'])->get();
    }

    /**
     * Get a program by id with its degree and faculty.
     *
     * @param int $id
     * @return Program|null
     */
    public function getById(int $id): ?Program
    {
        return Program::with(['degree:id,name', 'faculty:id,name'])->find($id);
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
        $query = Program::with(['degree:id,name', 'faculty:id,name']);

        if ($degreeId !== null) {
            $query->where('degree_id', $degreeId);
        }

        if ($facultyId !== null) {
            $query->where('faculty_id', $facultyId);
        }

        return $query->get();
    }
}

