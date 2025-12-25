<?php

namespace App\Livewire\Admin\Students;

use App\Mail\DiplomaMail;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Enums\DocumentStatusEnum;
use App\Models\Payments;
use App\Enums\PaymentStatusEnum;


#[Layout('layouts.admin')]
class Show extends Component
{
    public User $student;
    public ?Application $application = null;

    public function mount(User $student): void
    {
        $this->student = $student;

        // Get student's latest application with all related data
        $this->application = Application::with([
            'program.degree',
            'program.faculty',
            'studentApplication'
        ])
            ->where('user_id', $student->id)
            ->latest()
            ->first();
    }

    public function sendDiploma(): void
    {
        try {
            Log::info('=== sendDiploma metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            if (!$this->application) {
                session()->flash('error', 'Müraciət tapılmadı.');
                return;
            }

            // Fetch fresh application with all relationships from database
            $freshApplication = Application::with([
                'program.degree',
                'program.faculty',
                'studentApplication'
            ])->find($this->application->id);

            if (!$freshApplication) {
                session()->flash('error', 'Müraciət tapılmadı.');
                return;
            }

            Log::info('Application yükləndi', [
                'application_id' => $freshApplication->id,
                'program' => $freshApplication->program?->name ?? 'N/A',
                'degree' => $freshApplication->program?->degree?->name ?? 'N/A',
            ]);

            $studentApplication = $freshApplication->studentApplication;

            // Check mail configuration
            $mailDriver = config('mail.default');

            Mail::to($this->student->email)->send(new DiplomaMail(
                $this->student,
                $freshApplication,
                $studentApplication,
                now()->format('F d, Y')
            ));
            $this->application->update([
                'document_status' => DocumentStatusEnum::DIPLOMA_LETTER->value,
            ]);
            $this->application->load('studentApplication', 'documentVerifications');

            if ($mailDriver === 'log') {
                session()->flash('success', 'Diploma log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Diploma ' . $this->student->email . ' ünvanına göndərildi.');
            }
        } catch (\Exception $e) {
            Log::error('Diploma göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Diploma göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }

    public function render()
    {
        $paidPayments = Payments::where('user_id', $this->student->id)
            ->where('status', PaymentStatusEnum::PAID->value)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.students.show', [
            'paidPayments' => $paidPayments
        ]);
    }
}
