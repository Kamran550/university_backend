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
use App\Enums\DegreeTypeEnum;

class ApplicationService
{
    public function __construct(
        protected ApplicationRepositoryInterface $applicationRepository
    ) {
        //
    }

    /**
     * Handle file upload and return path.
     * Uses default disk (local or DO Spaces based on FILESYSTEM_DISK env)
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

        $disk = config('filesystems.default');

        Log::info('File upload attempt', [
            'disk' => $disk,
            'directory' => $directory,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

        try {
            $path = Storage::disk($disk)->putFileAs($directory, $file, $filename, 'public');
            Log::info('File uploaded successfully', ['path' => $path]);
            return $path;
        } catch (\Exception $e) {
            Log::error('File upload failed', [
                'error' => $e->getMessage(),
                'disk' => $disk,
            ]);
            throw $e;
        }
    }

    /**
     * Generate application number in format: 200109NNNN (10 digits total)
     * Format: Fixed prefix (200109) + Sequence (4)
     * Examples: 2001090001, 2001090002, 2001090099, 2001090100
     * 
     * @return string
     */
    protected function generateApplicationNumber(): string
    {
        $prefix = '200109'; // Fixed prefix for application numbers

        // Get the last student application with application_number
        $lastStudent = StudentApplication::orderBy('application_number', 'desc')
            ->where('application_number', 'like', $prefix . '%')
            ->whereNotNull('application_number')
            ->first();

        if ($lastStudent && $lastStudent->application_number) {
            // Extract the sequence number from the last application number (last 4 digits)
            $lastSequence = (int) substr($lastStudent->application_number, -4);
            $newSequence = $lastSequence + 1;
        } else {
            // First application
            $newSequence = 1;
        }

        // Format: 200109 + 4-digit sequence with leading zeros
        return $prefix . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate student number in format: YYYYMMNNNN (10 digits total)
     * Format: Year (4) + Month (2) + Sequence (4)
     * Examples: 2025120001, 2025120002, 2025120099, 2025120100
     * 
     * @return string
     */
    protected function generateStudentNumber(): string
    {
        // Generate prefix: YYYYMM (current year and month)
        $prefix = date('Y') . date('m'); // e.g., 202512

        // Get the last student application with the same prefix (same year and month)
        $lastStudent = StudentApplication::orderBy('student_number', 'desc')
            ->where('student_number', 'like', $prefix . '%')
            ->whereNotNull('student_number')
            ->first();

        if ($lastStudent && $lastStudent->student_number) {
            // Extract the sequence number from the last student number (last 4 digits)
            $lastSequence = (int) substr($lastStudent->student_number, -4);
            $newSequence = $lastSequence + 1;
        } else {
            // First student for this month
            $newSequence = 1;
        }

        // Format the new student number: YYYYMM + 4-digit sequence with leading zeros
        return $prefix . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate diploma number in format: 2025001NNN (10 digits total)
     * Format: Fixed prefix (2025001) + Sequence (3)
     * Examples: 2025001001, 2025001002, 2025001099, 2025001100
     * 
     * @return string
     */
    protected function generateDiplomaNumber(): string
    {
        $prefix = '2025001'; // Fixed prefix for diploma numbers

        // Get the last student application with diploma_number
        $lastStudent = StudentApplication::orderBy('diploma_number', 'desc')
            ->where('diploma_number', 'like', $prefix . '%')
            ->whereNotNull('diploma_number')
            ->first();

        if ($lastStudent && $lastStudent->diploma_number) {
            // Extract the sequence number from the last diploma number (last 3 digits)
            $lastSequence = (int) substr($lastStudent->diploma_number, -3);
            $newSequence = $lastSequence + 1;
        } else {
            // First diploma
            $newSequence = 1;
        }

        // Format: 2025001 + 3-digit sequence with leading zeros
        return $prefix . str_pad($newSequence, 3, '0', STR_PAD_LEFT);
    }


    protected function calculateGraduationYearForStudentApplication(int $duration)
    {
        $currentYear = (int) date('Y');

        return $currentYear + $duration;
    }
    protected function calculateGraduationYearForTransferApplication(int $duration, int $currentCourse)
    {
        $currentYear = (int) date('Y');
        return $currentYear + ($duration - $currentCourse + 1);
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

            Log::info('dataaa application:', ['app:', $data]);
            // Get program with degree information

            $degreeType = $data['degree_type'];
            $duration = Degree::findOrFail($data['degree_id'])->duration;
            $graduationYear = $this->calculateGraduationYearForStudentApplication($duration);
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

            // Determine which diploma and transcript fields to use based on degree level
            $highSchoolDiplomaPath = null;
            $highSchoolTranscriptPath = null;
            $bachelorDiplomaPath = null;
            $bachelorTranscriptPath = null;
            $masterDiplomaPath = null;
            $masterTranscriptPath = null;


            switch ($degreeType) {
                case DegreeTypeEnum::BACHELOR->value:
                    // Bachelor applicants provide high school documents
                    $highSchoolDiplomaPath = $this->handleFileUpload($data['high_school_diploma'] ?? null, 'applications/student/diplomas/high-school');
                    $highSchoolTranscriptPath = $this->handleFileUpload($data['high_school_transcript'] ?? null, 'applications/student/transcripts/high-school');
                    break;
                case DegreeTypeEnum::MASTER->value:
                    // Master applicants provide bachelor documents
                    $bachelorDiplomaPath = $this->handleFileUpload($data['bachelor_diploma'] ?? null, 'applications/student/diplomas/bachelor');
                    $bachelorTranscriptPath = $this->handleFileUpload($data['bachelor_transcript'] ?? null, 'applications/student/transcripts/bachelor');
                    break;
                case DegreeTypeEnum::phD->value:
                    // PhD applicants provide bachelor and master documents
                    $bachelorDiplomaPath = $this->handleFileUpload($data['bachelor_diploma'] ?? null, 'applications/student/diplomas/bachelor');
                    $bachelorTranscriptPath = $this->handleFileUpload($data['bachelor_transcript'] ?? null, 'applications/student/transcripts/bachelor');
                    $masterDiplomaPath = $this->handleFileUpload($data['master_diploma'] ?? null, 'applications/student/diplomas/master');
                    $masterTranscriptPath = $this->handleFileUpload($data['master_transcript'] ?? null, 'applications/student/transcripts/master');
                    break;
                case DegreeTypeEnum::MASTER_WITHOUT_THESIS->value:
                    // Master without thesis applicants provide bachelor documents
                    $bachelorDiplomaPath = $this->handleFileUpload($data['bachelor_diploma'] ?? null, 'applications/student/diplomas/bachelor');
                    $bachelorTranscriptPath = $this->handleFileUpload($data['bachelor_transcript'] ?? null, 'applications/student/transcripts/bachelor');
                    break;
            }
            // Generate numbers
            $applicationNumber = $this->generateApplicationNumber();
            $studentNumber = $this->generateStudentNumber();
            $diplomaNumber = $this->generateDiplomaNumber();

            

            // Prepare student application data
            $studentData = [
                'application_number' => $applicationNumber,
                'student_number' => $studentNumber,
                'diploma_number' => $diplomaNumber,
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
                'high_school_diploma_path' => $highSchoolDiplomaPath,
                'high_school_transcript_path' => $highSchoolTranscriptPath,
                'bachelor_diploma_path' => $bachelorDiplomaPath,
                'bachelor_transcript_path' => $bachelorTranscriptPath,
                'master_diploma_path' => $masterDiplomaPath,
                'master_transcript_path' => $masterTranscriptPath,
                'study_language' => $data['teachingLanguage'],
                'graduation_year' => $graduationYear,
            ];

            // Create student application
            $this->applicationRepository->createStudentApplication($application->id, $studentData);

            return $application->load('studentApplication');
        });
    }


        /**
     * Store a student application.
     *
     * @param array $data
     * @return Application
     */


     public function storeTransferApplication(array $data): Application
     {
         return DB::transaction(function () use ($data) {
             // Get degree and faculty names
 
             Log::info('dataaa application:', ['app:', $data]);
             // Get program with degree information
 
             $degreeType = $data['degree_type'];
             $duration = Degree::findOrFail($data['degree_id'])->duration;

             // Prepare application data
             $applicationData = [
                 'applicant_type' => ApplicationTypeEnum::TRANSFER->value,
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
 
             // Determine which diploma and transcript fields to use based on degree level
             $highSchoolDiplomaPath = null;
             $highSchoolTranscriptPath = null;
             $bachelorDiplomaPath = null;
             $bachelorTranscriptPath = null;
             $masterDiplomaPath = null;
             $masterTranscriptPath = null;
 
 
             switch ($degreeType) {
                 case DegreeTypeEnum::BACHELOR->value:
                     // Bachelor applicants provide high school documents
                     $highSchoolDiplomaPath = $this->handleFileUpload($data['high_school_diploma'] ?? null, 'applications/student/diplomas/high-school');
                     $highSchoolTranscriptPath = $this->handleFileUpload($data['high_school_transcript'] ?? null, 'applications/student/transcripts/high-school');
                     break;
                 case DegreeTypeEnum::MASTER->value:
                     // Master applicants provide bachelor documents
                     $bachelorDiplomaPath = $this->handleFileUpload($data['bachelor_diploma'] ?? null, 'applications/student/diplomas/bachelor');
                     $bachelorTranscriptPath = $this->handleFileUpload($data['bachelor_transcript'] ?? null, 'applications/student/transcripts/bachelor');
                     break;
                 case DegreeTypeEnum::phD->value:
                     // PhD applicants provide bachelor and master documents
                     $bachelorDiplomaPath = $this->handleFileUpload($data['bachelor_diploma'] ?? null, 'applications/student/diplomas/bachelor');
                     $bachelorTranscriptPath = $this->handleFileUpload($data['bachelor_transcript'] ?? null, 'applications/student/transcripts/bachelor');
                     $masterDiplomaPath = $this->handleFileUpload($data['master_diploma'] ?? null, 'applications/student/diplomas/master');
                     $masterTranscriptPath = $this->handleFileUpload($data['master_transcript'] ?? null, 'applications/student/transcripts/master');
                     break;
             }
             // Generate numbers
             $applicationNumber = $this->generateApplicationNumber();
             $studentNumber = $this->generateStudentNumber();
             $diplomaNumber = $this->generateDiplomaNumber();
             $graduationYear = $this->calculateGraduationYearForTransferApplication($duration, $data['current_course']);

 
             // Prepare student application data
             $studentData = [
                 'application_number' => $applicationNumber,
                 'student_number' => $studentNumber,
                 'diploma_number' => $diplomaNumber,
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
                 'high_school_diploma_path' => $highSchoolDiplomaPath,
                 'high_school_transcript_path' => $highSchoolTranscriptPath,
                 'bachelor_diploma_path' => $bachelorDiplomaPath,
                 'bachelor_transcript_path' => $bachelorTranscriptPath,
                 'master_diploma_path' => $masterDiplomaPath,
                 'master_transcript_path' => $masterTranscriptPath,
                 'study_language' => $data['teachingLanguage'],
                 'current_university' => $data['current_university'],
                 'current_course' => $data['current_course'],
                 'graduation_year' => $graduationYear,
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

    /**
     * Generate and assign diploma number to a student application.
     * This should be called when a student graduates.
     *
     * @param int $studentApplicationId
     * @return string The generated diploma number
     */
    public function generateAndAssignDiplomaNumber(int $studentApplicationId): string
    {
        $diplomaNumber = $this->generateDiplomaNumber();

        StudentApplication::where('id', $studentApplicationId)
            ->update(['diploma_number' => $diplomaNumber]);

        return $diplomaNumber;
    }
}
