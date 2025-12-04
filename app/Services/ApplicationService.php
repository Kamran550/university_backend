<?php

namespace App\Services;

use App\Enums\ApplicationStatusEnum;
use App\Enums\ApplicationTypeEnum;
use App\Models\Application;
use App\Models\Degree;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\StudentApplication;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationService
{
    public function __construct(
        protected ApplicationRepositoryInterface $applicationRepository
    ) {
        //
    }

    /**
     * Handle file upload and return path.
     *
     * @param UploadedFile|null $file
     * @param string $directory
     * @return string|null
     */
    protected function handleFileUpload(?UploadedFile $file, string $directory): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        
        return $path;
    }

    /**
     * Generate student number in format: 20251100XXXX (10 digits total)
     * Examples: 2025110001, 2025110002, 2025110011
     * 
     * @return string
     */
    protected function generateStudentNumber(): string
    {
        $prefix = '20251100';
        
        // Get the last student application to find the highest student number
        $lastStudent = StudentApplication::orderBy('student_number', 'desc')
            ->where('student_number', 'like', $prefix . '%')
            ->first();
        
        if ($lastStudent && $lastStudent->student_number) {
            // Extract the sequence number from the last student number (last 4 digits)
            $lastSequence = (int) substr($lastStudent->student_number, -4);
            $newSequence = $lastSequence + 1;
        } else {
            // First student
            $newSequence = 1;
        }
        
        // Format the new student number with leading zeros (4 digits)
        return $prefix . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
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
            Log::info('Program ID: ' . $data['program_id']);
            
            // Prepare application data
            $applicationData = [
                'applicant_type' => ApplicationTypeEnum::STUDENT->value,
                'program_id' => $data['program_id'],
                'status' => ApplicationStatusEnum::PENDING->value,
                'submitted_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'locale' => $data['locale'] ?? 'en',
            ];
            

            Log::info('Application data: ' . json_encode($applicationData));
            // Create application
            $application = $this->applicationRepository->create($applicationData);

            // Handle file uploads
            $photoIdPath = $this->handleFileUpload($data['photo_id'] ?? null, 'applications/student/photo-ids');
            $profilePhotoPath = $this->handleFileUpload($data['profile_photo'] ?? null, 'applications/student/profile-photos');
            $diplomaPath = $this->handleFileUpload($data['diploma'] ?? null, 'applications/student/diplomas');
            $transcriptPath = $this->handleFileUpload($data['transcript'] ?? null, 'applications/student/transcripts');

            // Generate student number
            $studentNumber = $this->generateStudentNumber();

            // Prepare student application data
            $studentData = [
                'student_number' => $studentNumber,
                'passport_number' => $data['passport_number'] ?? null,
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
                'photo_id_path' => $photoIdPath,
                'profile_photo_path' => $profilePhotoPath,
                'diploma_path' => $diplomaPath,
                'transcript_path' => $transcriptPath,
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

            // Handle file uploads
            $businessLicensePath = $this->handleFileUpload($data['business_license'] ?? null, 'applications/agency/business-licenses');
            $companyLogoPath = $this->handleFileUpload($data['company_logo'] ?? null, 'applications/agency/company-logos');

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
                'business_license_path' => $businessLicensePath,
                'company_logo_path' => $companyLogoPath,
            ];

            // Create agency application
            $this->applicationRepository->createAgencyApplication($application->id, $agencyData);

            return $application->load('agencyApplication');
        });
    }
}

