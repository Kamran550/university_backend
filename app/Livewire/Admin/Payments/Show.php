<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payments;
use App\Models\DocumentVerification;
use App\Enums\DocumentTypeEnum;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Show extends Component
{
    public Payments $payment;
    public $isDownloading = false;

    public function mount(Payments $payment): void
    {
        $this->payment = $payment->load(['user.applications.studentApplication']);
    }

    public function downloadReceipt()
    {
        try {
            $this->isDownloading = true;

            // Check if document verification record already exists
            $existingVerification = DocumentVerification::where('payment_id', $this->payment->id)
                ->where('document_type', DocumentTypeEnum::PAYMENT->value)
                ->first();

            if ($existingVerification) {
                // Use existing record - download from storage
                $filePath = $existingVerification->file_path;
                $fileName = basename($filePath);
                $fileContent = Storage::get($filePath);

                Log::info('Payment receipt downloaded from existing record', [
                    'payment_id' => $this->payment->id,
                    'verification_code' => $existingVerification->verification_code,
                    'file_path' => $filePath
                ]);

                return response()->streamDownload(function () use ($fileContent) {
                    echo $fileContent;
                }, $fileName, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            }

            // First time download - create new record and save to storage
            // Generate verification code
            $verificationCode = strtoupper(Str::random(14));

            // Calculate academic year range
            $academicYear = $this->payment->academic_year;
            $academicYearRange = $academicYear . '-' . ($academicYear + 1);

            // Get invoiced number (use payment's invoiced_number)
            $invoicedNumber = $this->payment->invoiced_number ?? 'N/A';
            $studentNumber = $this->payment->user->applications()->first()?->studentApplication?->student_number ?? 'N/A';
            $passportNumber = $this->payment->user->applications()->first()?->studentApplication?->passport_number ?? 'N/A';
            // Generate PDF
            $pdf = Pdf::loadView('pdfs.payment-receipt', [
                'payment' => $this->payment,
                'user' => $this->payment->user,
                'academicYearRange' => $academicYearRange,
                'verificationCode' => $verificationCode,
                'invoicedNumber' => $invoicedNumber,
                'studentNumber' => $studentNumber,
                'passportNumber' => $passportNumber,
            ])
                ->setOptions([
                    'isRemoteEnabled' => false,
                    'isHtml5ParserEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'defaultFont' => 'DejaVu Serif'
                ])
                ->setPaper('a4', 'portrait');

            // Generate unique file name and path (include payment ID to make it unique)
            $userName = str_replace(' ', '_', strtoupper($this->payment->user->name . ' ' . $this->payment->user->surname));
            $fileName = $userName . '_PAYMENT_RECEIPT_' . $this->payment->id . '.pdf';
            $filePath = 'payments/receipts/' . $fileName;

            // Save PDF to storage
            Storage::put($filePath, $pdf->output());
            Log::info('Payment receipt saved to storage', ['path' => $filePath]);

            // Store verification record with file path
            DocumentVerification::create([
                'payment_id' => $this->payment->id,
                'document_type' => DocumentTypeEnum::PAYMENT->value,
                'verification_code' => $verificationCode,
                'file_path' => $filePath,
                'verified_at' => now(),
            ]);
            Log::info('Document verification record created', [
                'payment_id' => $this->payment->id,
                'verification_code' => $verificationCode,
                'file_path' => $filePath
            ]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            $this->isDownloading = false;
            Log::error('Payment Receipt PDF Generation Error: ' . $e->getMessage());
            session()->flash('error', 'Error generating payment receipt: ' . $e->getMessage());
            return null;
        } finally {
            $this->isDownloading = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.payments.show');
    }
}
