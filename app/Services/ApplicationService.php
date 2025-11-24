<?php

namespace App\Services;

use App\Enums\ApplicationStatusEnum;
use App\Enums\ApplicationTypeEnum;
use App\Models\Application;
use App\Models\Degree;
use App\Models\Faculty;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ApplicationService
{
    public function __construct(
        protected ApplicationRepositoryInterface $applicationRepository
    ) {
        //
    }

    /**
     * Store a student application.
     *
     * @param array $data
     * @return Application
     */
    public function storeStudentApplication(array $data): Application
    {
        return DB::transaction(function () use ($data) {
            // Get degree and faculty names
            $degree = Degree::findOrFail($data['degree_id']);
            $faculty = Faculty::findOrFail($data['faculty_id']);

            // Prepare application data
            $applicationData = [
                'applicant_type' => ApplicationTypeEnum::STUDENT->value,
                'degree_id' => $data['degree_id'],
                'degree_name' => $degree->name,
                'faculty_id' => $data['faculty_id'],
                'faculty_name' => $faculty->name,
                'status' => ApplicationStatusEnum::PENDING->value,
                'submitted_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'locale' => $data['locale'] ?? 'en',
            ];

            // Create application
            $application = $this->applicationRepository->create($applicationData);

            // Prepare student application data
            $studentData = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'father_name' => $data['father_name'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['date_of_birth'],
                'place_of_birth' => $data['place_of_birth'],
                'nationality' => $data['nationality'],
                'native_language' => $data['native_language'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'country' => $data['country'],
                'city' => $data['city'],
                'address_line' => $data['address_line'],
                'photo_id_path' => $data['photo_id_path'],
                'profile_photo_path' => $data['profile_photo_path'] ?? null,
                'diploma_path' => $data['diploma_path'] ?? null,
                'transcript_path' => $data['transcript_path'],
            ];

            // Create student application
            $this->applicationRepository->createStudentApplication($application->id, $studentData);

            return $application->load('studentApplication');
        });
    }

    /**
     * Store an agency application.
     *
     * @param array $data
     * @return Application
     */
    public function storeAgencyApplication(array $data): Application
    {
        return DB::transaction(function () use ($data) {
            // Get degree and faculty names
            $degree = Degree::findOrFail($data['degree_id']);
            $faculty = Faculty::findOrFail($data['faculty_id']);

            // Prepare application data
            $applicationData = [
                'applicant_type' => ApplicationTypeEnum::AGENCY->value,
                'degree_id' => $data['degree_id'],
                'degree_name' => $degree->name,
                'faculty_id' => $data['faculty_id'],
                'faculty_name' => $faculty->name,
                'status' => ApplicationStatusEnum::PENDING->value,
                'submitted_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'locale' => $data['locale'] ?? 'en',
            ];

            // Create application
            $application = $this->applicationRepository->create($applicationData);

            // Prepare agency application data
            $agencyData = [
                'agency_name' => $data['agency_name'],
                'country' => $data['country'],
                'city' => $data['city'],
                'address' => $data['address'],
                'website' => $data['website'] ?? null,
                'contact_name' => $data['contact_name'],
                'contact_phone' => $data['contact_phone'],
                'contact_email' => $data['contact_email'],
                'business_license_path' => $data['business_license_path'] ?? null,
                'company_logo_path' => $data['company_logo_path'] ?? null,
            ];

            // Create agency application
            $this->applicationRepository->createAgencyApplication($application->id, $agencyData);

            return $application->load('agencyApplication');
        });
    }
}

