<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FacultyRepositoryInterface
{
    /**
     * Get all faculties.
     *
     * @return Collection
     */
    public function getAll();
    public function getById(int $id);
}
