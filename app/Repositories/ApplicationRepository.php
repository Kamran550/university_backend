<?php

namespace App\Repositories;

use App\Models\Application;
use App\Models\StudentApplication;
use App\Models\AgencyApplication;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    public function create(array $data): Application
    {
        return Application::create($data);
    }
    
    public function createStudentApplication(int $applicationId, array $data): StudentApplication
    {
        $data['application_id'] = $applicationId;
        return StudentApplication::create($data);
    }
    
    public function createAgencyApplication(int $applicationId, array $data): AgencyApplication
    {
        $data['application_id'] = $applicationId;
        return AgencyApplication::create($data);
    }
}