<?php

namespace App\Mail;

use App\Models\DocumentVerification;
use App\Models\StudentApplication;
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
use App\Enums\DocumentTypeEnum;

class AcceptanceLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public StudentApplication $student;

    /**
     * Create a new message instance.
     */
    public function __construct(StudentApplication $student)
    {
        $this->student = $student;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Şərtli Qəbul Məktubu - ' . $this->student->first_name . ' ' . $this->student->last_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.acceptance-letter',
            with: [
                'student' => $this->student,
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
            // Ensure student has application relationship loaded
            if (!$this->student->relationLoaded('application')) {
                $this->student->load('application');
            }

            $verificationCode = null;
            if ($this->student->application) {
                $verificationCode = strtoupper(Str::random(14));
                
                $documentVerification = DocumentVerification::create([
                    'application_id' => $this->student->application->id,
                    'document_type' => DocumentTypeEnum::ACCEPTANCE,
                    'verification_code' => $verificationCode,
                    'file_path' => null, // Will be updated after PDF is saved
                ]);

                // Load the relationship so it's available in the view
                $this->student->application->load('documentVerifications');
            }
    
            // Generate PDF from the acceptance letter blade template
            $pdf = Pdf::loadView('livewire.admin.applications.student.acceptance-letter', [
                'student' => $this->student,
            ])->setPaper('a4', 'portrait');

            $fileName = 'Qebul_Mektubu_' . $this->student->first_name . '_' . $this->student->last_name . '_' . now()->format('Y-m-d') . '.pdf';
            $filePath = 'applications/acceptance-letters/' . $fileName;

            // Save PDF to storage
            Storage::disk('public')->put($filePath, $pdf->output());
            if ($this->student->application && isset($documentVerification)) {
                $documentVerification->update([
                    'file_path' => $filePath,
                ]);
            }

            return [
                Attachment::fromData(fn () => $pdf->output(), $fileName)
                    ->withMime('application/pdf'),
            ];
        } catch (\Exception $e) {
            Log::error('PDF generate edərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return empty array if PDF generation fails
        return [];
        }
    }
}
