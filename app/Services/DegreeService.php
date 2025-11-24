<?php

namespace App\Services;

use App\Models\Degree;
use App\Repositories\Interfaces\DegreeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;



class DegreeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected DegreeRepositoryInterface $degreeRepository

    ){
    }

        /**
     * Get all degrees.
     *
     * @return Collection
     */

     public function getAll(): Collection
     {
        return $this->degreeRepository->getAll();
     }


     /**
     * Get a degree by id.
     *
     * @param int $id
     * @return Degree|null
     */
    public function getById(int $id): ?Degree
    {
        return $this->degreeRepository->getById($id);
    }

}
