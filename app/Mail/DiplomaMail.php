<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\StudentApplication;
use App\Models\User;
use App\Models\DocumentVerification;
use App\Enums\DocumentTypeEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiplomaMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $student;
    public Application $application;
    public ?StudentApplication $studentApplication;
    public ?string $graduationDate;

    /**
     * Create a new message instance.
     */
    public function __construct(
        User $student, 
        Application $application, 
        ?StudentApplication $studentApplication = null,
        ?string $graduationDate = null
    ) {
        $this->student = $student;
        $this->application = $application;
        $this->studentApplication = $studentApplication;
        $this->graduationDate = $graduationDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $studentName = $this->studentApplication 
            ? $this->studentApplication->first_name . ' ' . $this->studentApplication->last_name
            : $this->student->name . ' ' . $this->student->surname;
            
        return new Envelope(
            subject: 'Diploma Certificate - ' . $studentName . ' - European International Peace University',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.diploma',
            with: [
                'student' => $this->student,
                'application' => $this->application,
                'studentApplication' => $this->studentApplication,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        try {
            Log::info('Diploma PDF generasiyası başladı', [
                'student_id' => $this->student->id,
                'application_id' => $this->application->id,
            ]);

            // Ensure relationships are loaded
            if (!$this->application->relationLoaded('program')) {
                $this->application->load(['program.degree', 'program.faculty']);
            }

            // Generate verification code
            $verificationCode = strtoupper(Str::random(14));
            
            // Create document verification record
            $documentVerification = DocumentVerification::create([
                'application_id' => $this->application->id,
                'document_type' => DocumentTypeEnum::DIPLOMA,
                'verification_code' => $verificationCode,
                'file_path' => null,
            ]);

            Log::info('DocumentVerification yaradıldı', [
                'verification_code' => $verificationCode,
            ]);

            // Generate PDF from diploma blade template (landscape A4)
            $pdf = Pdf::loadView('livewire.admin.students.diploma', [
                'student' => $this->student,
                'application' => $this->application,
                'studentApplication' => $this->studentApplication,
                'verificationCode' => $verificationCode,
                'graduationDate' => $this->graduationDate ?? now()->format('F d, Y'),
            ])->setPaper('a4', 'landscape');

            Log::info('PDF yaradıldı');

            $studentName = $this->studentApplication 
                ? $this->studentApplication->first_name . '_' . $this->studentApplication->last_name
                : $this->student->name . '_' . ($this->student->surname ?? '');

            // Clean filename
            $studentName = preg_replace('/[^A-Za-z0-9_]/', '', $studentName);
            
            $fileName = 'Diploma_' . $studentName . '_' . now()->format('Y-m-d') . '.pdf';
            $filePath = 'applications/diplomas/' . $fileName;

            // Generate PDF output once
            $pdfOutput = $pdf->output();

            // Save PDF to storage (uses default disk - local or DO Spaces based on env)
            Storage::put($filePath, $pdfOutput);

            Log::info('PDF storage-a saxlanıldı', [
                'file_path' => $filePath,
            ]);

            // Update document verification with file path
            $documentVerification->update([
                'file_path' => $filePath,
            ]);

            return [
                Attachment::fromData(fn () => $pdfOutput, $fileName)
                    ->withMime('application/pdf'),
            ];
        } catch (\Exception $e) {
            Log::error('Diploma PDF generate edərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'application_id' => $this->application->id,
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }
}

