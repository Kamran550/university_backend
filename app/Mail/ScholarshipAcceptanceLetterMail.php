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
use App\Enums\ScholarshipStatusEnum;

class ScholarshipAcceptanceLetterMail extends Mailable
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
            subject: '100% Scholarship - Conditional Acceptance Letter - ' . $this->student->first_name . ' ' . $this->student->last_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.scholarship-acceptance-letter',
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

            $this->student->scholarship_status = ScholarshipStatusEnum::PERCENT_100->value;
            $this->student->save();

            // Generate PDF from the scholarship acceptance letter blade template
            $pdf = Pdf::loadView('livewire.admin.applications.student.scholarship-acceptance-letter', [
                'student' => $this->student,
                'verificationCode' => $verificationCode,
            ])
                ->setOptions([
                    'isRemoteEnabled' => false,
                    'isHtml5ParserEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'defaultFont' => 'DejaVu Serif'
                ])->setPaper('a4', 'portrait');

            $fileName = '100_Scholarship_CAL_' . $this->student->student_number . '_' . $this->student->first_name . '_' . $this->student->last_name . '.pdf';
            $filePath = 'applications/scholarship-acceptance-letters/' . $fileName;

            // Save PDF to storage (uses default disk - local or DO Spaces based on env)
            Storage::put($filePath, $pdf->output());
            if ($this->student->application && isset($documentVerification)) {
                $documentVerification->update([
                    'file_path' => $filePath,
                ]);
            }


            return [
                Attachment::fromData(fn() => $pdf->output(), $fileName)
                    ->withMime('application/pdf'),
            ];
        } catch (\Exception $e) {
            Log::error('Error generating 100% Scholarship PDF: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'trace' => $e->getTraceAsString()
            ]);

            // Return empty array if PDF generation fails
            return [];
        }
    }
}
