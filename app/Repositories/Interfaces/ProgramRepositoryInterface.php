<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProgramRepositoryInterface
{
    /**
     * Get all programs.
     *
     * @return Collection
     */
    public function getAll();

    /**
     * Get a program by id.
     *
     * @param int $id
     * @return \App\Models\Program|null
     */
    public function getById(int $id);

    /**
     * Get programs filtered by degree_id and/or faculty_id and/or language.
     *
     * @param int|null $degreeId
     * @param int|null $facultyId
     * @param string|null $lang
     * @return Collection
     */
    public function getFiltered(?int $degreeId = null, ?int $facultyId = null, ?string $lang = null);
}

