<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Collection;


interface DegreeRepositoryInterface
{
    /**
     * Create a new class instance.
     */

         /**
     * Get all faculties.
     *
     * @return Collection
     */


     public function getAll();
     public function getById(int $id);
}
