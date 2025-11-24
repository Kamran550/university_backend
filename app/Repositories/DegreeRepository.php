<?php

namespace App\Repositories;

use App\Models\Degree;
use App\Repositories\Interfaces\DegreeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;


class DegreeRepository implements DegreeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
        /**
     * Get all faculties.
     *
     * @return Collection
     */

     public function getAll(): Collection
     {
        return Degree::with('faculties:id,name')->get();
     }


     /**
     * Get a degree by id.
     *
     * @param int $id
     * @return Degree|null
     */
    public function getById(int $id): ?Degree
    {
        return Degree::with('faculties:id,name')->find($id);
    }

}
