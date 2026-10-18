<?php

namespace App\Http\Controllers;

use App\Enums\DocumentTypeEnum;
use App\Models\AgencyApplication;
use App\Models\DocumentVerification;
use App\Models\StudentApplication;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Headers that keep private files out of browser and proxy caches.
     */
    protected const PRIVATE_HEADERS = [
        'Cache-Control' => 'private, no-store, max-age=0',
        'X-Content-Type-Options' => 'nosniff',
    ];

    /**
     * Allowed student document types mapped to their path columns.
     */
    protected const STUDENT_DOCUMENTS = [
        'photo_id' => 'photo_id_path',
        'profile_photo' => 'profile_photo_path',
        'high_school_diploma' => 'high_school_diploma_path',
        'high_school_transcript' => 'high_school_transcript_path',
        'bachelor_diploma' => 'bachelor_diploma_path',
        'bachelor_transcript' => 'bachelor_transcript_path',
        'master_diploma' => 'master_diploma_path',
        'master_transcript' => 'master_transcript_path',
    ];

    /**
     * Allowed agency document types mapped to their path columns.
     */
    protected const AGENCY_DOCUMENTS = [
        'business_license' => 'business_license_path',
        'company_logo' => 'company_logo_path',
    ];

    /**
     * Stream a student application document to an admin (route is behind admin middleware).
     */
    public function studentDocument(StudentApplication $studentApplication, string $type): StreamedResponse
    {
        abort_unless(isset(self::STUDENT_DOCUMENTS[$type]), 404);

        return $this->stream($studentApplication->{self::STUDENT_DOCUMENTS[$type]}, $type);
    }

    /**
     * Stream an agency application document to an admin (route is behind admin middleware).
     */
    public function agencyDocument(AgencyApplication $agencyApplication, string $type): StreamedResponse
    {
        abort_unless(isset(self::AGENCY_DOCUMENTS[$type]), 404);

        return $this->stream($agencyApplication->{self::AGENCY_DOCUMENTS[$type]}, $type);
    }

    /**
     * Stream a verifiable document by its verification code (public verify page).
     */
    public function verifyDocument(string $code): StreamedResponse
    {
        $document = DocumentVerification::where('verification_code', strtoupper(trim($code)))
            ->whereIn('document_type', [
                DocumentTypeEnum::ACCEPTANCE->value,
                DocumentTypeEnum::CERTIFICATE->value,
                DocumentTypeEnum::DIPLOMA->value,
            ])
            ->whereNotNull('file_path')
            ->firstOrFail();

        return $this->stream($document->file_path, $document->document_type->value);
    }

    /**
     * Stream a file inline from the default disk (where these files are stored).
     * The download name is built from the document type, never from the stored path.
     */
    protected function stream(?string $path, string $name): StreamedResponse
    {
        abort_if(empty($path), 404);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk();

        abort_unless($disk->exists($path), 404);

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $filename = $extension ? "{$name}.{$extension}" : $name;

        return $disk->response($path, $filename, self::PRIVATE_HEADERS, 'inline');
    }
}
