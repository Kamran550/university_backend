<?php

namespace App\Repositories\Interfaces;

use App\Models\Application;
use App\Models\StudentApplication;
use App\Models\AgencyApplication;

interface ApplicationRepositoryInterface
{
    public function create(array $data): Application;
    
    public function createStudentApplication(int $applicationId, array $data): StudentApplication;

    public function createAgencyApplication(int $applicationId, array $data): AgencyApplication;
}