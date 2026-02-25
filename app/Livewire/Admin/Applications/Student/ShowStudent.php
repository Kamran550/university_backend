<?php

namespace App\Livewire\Admin\Applications\Student;

use App\Enums\ApplicationStatusEnum;
use App\Enums\DegreeTypeEnum;
use App\Mail\AcceptanceLetterMail;
use App\Mail\FinalAcceptanceLetterMail;
use App\Mail\FinalAcceptanceLetterTurkishMail;
use App\Mail\FinalScholarshipAcceptanceLetterMail;
use App\Mail\ScholarshipAcceptanceLetterMail;
use App\Mail\TransferLetterMail;
use App\Mail\TransferLetterEnglishMail;
use App\Models\Degree;
use App\Models\StudentApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Enums\DocumentStatusEnum;

#[Layout('layouts.admin')]
class ShowStudent extends Component
{
    public StudentApplication $student;

    public function mount(StudentApplication $student): void
    {
        $this->student = $student->load('application.program.studyLanguages');
    }

    public function sendAcceptanceLetter()
    {
        try {
            Log::info('=== sendAcceptanceLetter metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            // Reload student with application relationship
            $this->student->load('application');

            // Check mail configuration
            $mailDriver = config('mail.default');

            Mail::to($this->student->email)->send(new AcceptanceLetterMail($this->student));

            $this->student->application->update([
                'document_status' => DocumentStatusEnum::ACCAPTANCE_LETTER->value,
            ]);

            $this->student->load('application');


            if ($mailDriver === 'log') {
                session()->flash('success', 'Mail log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Conditional Acceptance Letter sent to ' . $this->student->email . ' email address.');
            }
        } catch (\Exception $e) {
            Log::error('Mail göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Mail göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }

    public function sendScholarshipAcceptanceLetter()
    {
        try {
            Log::info('=== sendScholarshipAcceptanceLetter metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            // Reload student with application relationship
            $this->student->load('application');

            // Check mail configuration
            $mailDriver = config('mail.default');

            Mail::to($this->student->email)->send(new ScholarshipAcceptanceLetterMail($this->student));

            $this->student->application->update([
                'document_status' => DocumentStatusEnum::ACCAPTANCE_LETTER->value,
            ]);

            $this->student->load('application');

            if ($mailDriver === 'log') {
                session()->flash('success', '100% Scholarship Conditional Acceptance Letter log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', '100% Scholarship Conditional Acceptance Letter sent to ' . $this->student->email . ' email address.');
            }
        } catch (\Exception $e) {
            Log::error('100% Scholarship letter göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = '100% Scholarship letter göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }

    public function sendTransferLetter()
    {
        try {
            Log::info('=== sendTransferLetter metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            // Reload student with application relationship
            $this->student->load('application');

            // Check mail configuration
            $mailDriver = config('mail.default');

            Mail::to($this->student->email)->send(new TransferLetterMail($this->student));

            $this->student->application->update([
                'document_status' => DocumentStatusEnum::TRANSFER_TURKISH_LETTER->value,

            ]);
            $this->student->load('application');

            if ($mailDriver === 'log') {
                session()->flash('success', 'Transfer mektubu log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Transfer Kabul Mektubu ' . $this->student->email . ' email adresine gönderildi.');
            }
        } catch (\Exception $e) {
            Log::error('Transfer mektubu göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Transfer mektubu göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }

    public function sendTransferLetterEnglish()
    {
        try {
            Log::info('=== sendTransferLetterEnglish metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            $this->student->load('application');

            $mailDriver = config('mail.default');

            Mail::to($this->student->email)->send(new TransferLetterEnglishMail($this->student));

            $this->student->application->update([
                'document_status' => DocumentStatusEnum::TRANSFER_ENGLISH_LETTER->value,
            ]);
            $this->student->load('application');

            if ($mailDriver === 'log') {
                session()->flash('success', 'Transfer Letter (English) log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Transfer Acceptance Letter (English) ' . $this->student->email . ' email adresine gönderildi.');
            }
        } catch (\Exception $e) {
            Log::error('Transfer Letter (English) göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Transfer Letter (English) göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }

    public function updateStatus(string $status): void
    {
        try {
            if (!$this->student->application) {
                session()->flash('error', 'Müraciət tapılmadı.');
                return;
            }

            $statusEnum = ApplicationStatusEnum::tryFrom($status);

            if (!$statusEnum) {
                session()->flash('error', 'Yanlış status dəyəri.');
                return;
            }

            $this->student->application->update([
                'status' => $statusEnum,
                'reviewed_at' => now(),
            ]);

            // Reload the student with application
            $this->student->load('application');

            $statusLabel = str($status)->replace('_', ' ')->title()->value();
            session()->flash('success', "Status '{$statusLabel}' olaraq yeniləndi.");
        } catch (\Exception $e) {
            Log::error('Status yenilənərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'status' => $status,
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Status yenilənərkən xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function sendFinalAcceptanceLetter()
    {
        try {
            Log::info('=== sendFinalAcceptanceLetter metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            if (!$this->student->application) {
                session()->flash('error', 'Müraciət tapılmadı.');
                return;
            }

            // Reload student with application relationship
            $this->student->load('application.program.degree.translations', 'application.program.translations', 'application.program.faculty.translations');

            // Generate diploma text in EN and TR (degree type-a görə)
            $program = $this->student->application->program;
            $degree = $program?->degree;
            $faculty = $program?->faculty;

            $programNameEn = $program?->getName('EN') ?: $program?->name;
            $programNameTr = $program?->getName('TR') ?: $program?->name;
            $degreeNameEn = $degree?->getName('EN') ?: $degree?->name;
            $degreeNameTr = $degree?->getName('TR') ?: $degree?->name;
            $facultyNameEn = $faculty?->getName('EN') ?: $faculty?->name;
            $facultyNameTr = $faculty?->getName('TR') ?: $faculty?->name;

            $diplomaText = $this->generateDiplomaText($degree, $programNameEn, $programNameTr, $degreeNameEn, $degreeNameTr, $facultyNameEn, $facultyNameTr);

            // Save diploma text to student application
            $this->student->update([
                'diploma_text' => $diplomaText,
            ]);

            Log::info('Diploma text saved', ['diploma_text' => $diplomaText]);

            // Check if user already exists
            $user = User::where('email', $this->student->email)->first();

            Log::info('User: ', ['user:', $user]);
            $plainPassword = null;

            if (!$user) {
                // Generate random password
                $plainPassword = Str::random(12);

                // Create new user
                $user = DB::transaction(function () use ($plainPassword) {
                    Log::info('Password: ' . $plainPassword);

                    // Get student role (assuming role_id 3 is for students, adjust as needed)
                    $user = User::create([
                        'name' => $this->student->first_name,
                        'surname' => $this->student->last_name,
                        'email' => $this->student->email,
                        'username' => $this->student->student_number,
                        'phone' => $this->student->phone,
                        'password' => Hash::make($plainPassword),
                        'role_id' => 3, // Default to first role if student role doesn't exist
                    ]);

                    // Link application to user
                    $this->student->application->update([
                        'user_id' => $user->id,
                    ]);

                    Log::info('Yeni istifadəçi yaradıldı', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'username' => $user->username,
                    ]);

                    return $user;
                });
            } else {
                // Link application to existing user if not already linked
                if (!$this->student->application->user_id) {
                    $this->student->application->update([
                        'user_id' => $user->id,
                    ]);
                }
            }

            // Check mail configuration
            $mailDriver = config('mail.default');

            Log::info('PASsssssword: ', ['password:', $plainPassword]);

            Mail::to($this->student->email)->send(new FinalAcceptanceLetterMail($this->student, $user, $plainPassword));

            $this->student->application->update([
                'document_status' => DocumentStatusEnum::CERTIFICATE_ENGLISH_LETTER->value,
            ]);
            $this->student->load('application');

            if ($mailDriver === 'log') {
                session()->flash('success', 'Tam qəbul məktubu log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Tam qəbul məktubu ' . $this->student->email . ' ünvanına göndərildi.');
            }
        } catch (\Exception $e) {
            Log::error('Tam qəbul məktubu göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Tam qəbul məktubu göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }
    public function sendFinalAcceptanceLetterTurkish()
    {
        try {
            Log::info('=== sendFinalAcceptanceLetterTurkish metodu çağırıldı ===');
            Log::info('Student ID: ' . $this->student->id);
            Log::info('Student Email: ' . ($this->student->email ?? 'YOXDUR'));

            if (!$this->student->email) {
                Log::warning('Email ünvanı yoxdur!');
                session()->flash('error', 'Tələbənin email ünvanı yoxdur.');
                return;
            }

            if (!$this->student->application) {
                session()->flash('error', 'Müraciət tapılmadı.');
                return;
            }

            // Reload student with application relationship
            $this->student->load('application.program.degree.translations', 'application.program.translations', 'application.program.faculty.translations');

            // Generate diploma text in EN and TR (degree type-a görə)
            $program = $this->student->application->program;
            $degree = $program?->degree;
            $faculty = $program?->faculty;

            $programNameEn = $program?->getName('EN') ?: $program?->name;
            $programNameTr = $program?->getName('TR') ?: $program?->name;
            $degreeNameEn = $degree?->getName('EN') ?: $degree?->name;
            $degreeNameTr = $degree?->getName('TR') ?: $degree?->name;
            $facultyNameEn = $faculty?->getName('EN') ?: $faculty?->name;
            $facultyNameTr = $faculty?->getName('TR') ?: $faculty?->name;

            $diplomaText = $this->generateDiplomaText($degree, $programNameEn, $programNameTr, $degreeNameEn, $degreeNameTr, $facultyNameEn, $facultyNameTr);

            // Save diploma text to student application
            $this->student->update([
                'diploma_text' => $diplomaText,
            ]);

            Log::info('Diploma text saved', ['diploma_text' => $diplomaText]);

            // Check if user already exists
            $user = User::where('email', $this->student->email)->first();

            Log::info('User: ', ['user:', $user]);
            $plainPassword = null;

            if (!$user) {
                // Generate random password
                $plainPassword = Str::random(12);

                // Create new user
                $user = DB::transaction(function () use ($plainPassword) {
                    Log::info('Password: ' . $plainPassword);

                    // Get student role (assuming role_id 3 is for students, adjust as needed)
                    $user = User::create([
                        'name' => $this->student->first_name,
                        'surname' => $this->student->last_name,
                        'email' => $this->student->email,
                        'username' => $this->student->student_number,
                        'phone' => $this->student->phone,
                        'password' => Hash::make($plainPassword),
                        'role_id' => 3, // Default to first role if student role doesn't exist
                    ]);

                    // Link application to user
                    $this->student->application->update([
                        'user_id' => $user->id,
                    ]);

                    Log::info('Yeni istifadəçi yaradıldı', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'username' => $user->username,
                    ]);

                    return $user;
                });
            } else {
                // Link application to existing user if not already linked
                if (!$this->student->application->user_id) {
                    $this->student->application->update([
                        'user_id' => $user->id,
                    ]);
                }
            }

            // Check mail configuration
            $mailDriver = config('mail.default');

            Log::info('PASsssssword: ', ['password:', $plainPassword]);

            Mail::to($this->student->email)->send(new FinalAcceptanceLetterTurkishMail($this->student, $user, $plainPassword));

            $this->student->application->update([
                'document_status' => DocumentStatusEnum::CERTIFICATE_TURKISH_LETTER->value,
            ]);
            $this->student->load('application');

            if ($mailDriver === 'log') {
                session()->flash('success', 'Öğrenci belgesi log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Öğrenci belgesi ' . $this->student->email . ' ünvanına göndərildi.');
            }
        } catch (\Exception $e) {
            Log::error('Öğrenci belgesi göndərilərkən xəta: ' . $e->getMessage(), [
                'student_id' => $this->student->id,
                'email' => $this->student->email,
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Öğrenci belgesi göndərilərkən xəta baş verdi: ' . $e->getMessage();
            if (str_contains($e->getMessage(), 'Connection') || str_contains($e->getMessage(), 'SMTP')) {
                $errorMessage .= ' SMTP konfiqurasiyasını yoxlayın.';
            }

            session()->flash('error', $errorMessage);
        }
    }



    /**
     * Resolve DegreeTypeEnum from $degree (tələbənin müraciət etdiyi degree).
     * $degree ilə switch üçün tələbənin apply etdiyi degree type-ı təyin edir.
     */
    private function resolveDegreeType(?Degree $degree): ?DegreeTypeEnum
    {
        $degreeNameEn = $degree?->getName('EN') ?: $degree?->name;
        if (!$degreeNameEn) {
            return null;
        }
        $name = strtolower($degreeNameEn);
        if (str_contains($name, 'phd') || str_contains($name, 'doctor')) {
            return DegreeTypeEnum::phD;
        }
        if (str_contains($name, 'without thesis') || str_contains($name, 'tezsiz')) {
            return DegreeTypeEnum::MASTER_WITHOUT_THESIS;
        }
        if (str_contains($name, 'master') || str_contains($name, 'mba') || str_contains($name, 'ma ') || str_contains($name, 'ms ')) {
            return DegreeTypeEnum::MASTER;
        }
        if (str_contains($name, 'bachelor') || str_contains($name, 'bba') || str_contains($name, 'lisans')) {
            return DegreeTypeEnum::BACHELOR;
        }
        return null;
    }

    /**
     * Generate diploma text based on degree type.
     * $degree ilə switch - tələbənin apply etdiyi degree-ə görə diploma mətni yaradır.
     */
    private function generateDiplomaText(
        ?Degree $degree,
        string $programNameEn,
        string $programNameTr,
        string $degreeNameEn,
        string $degreeNameTr,
        ?string $facultyNameEn = null,
        ?string $facultyNameTr = null
    ): array {
        $degreeType = $this->resolveDegreeType($degree);
        Log::info('Degree Type: ', ['degree_type:', $degreeType]);
        Log::info('degree: ', ['degree:', $degree]);
        Log::info('degree name: ', ['degree_name:', $degreeNameEn]);
        Log::info('degree name tr: ', ['degree_name_tr:', $degreeNameTr]);
        Log::info('faculty name en: ', ['faculty_name_en:', $facultyNameEn]);
        Log::info('faculty name tr: ', ['faculty_name_tr:', $facultyNameTr]);
        Log::info('program name en: ', ['program_name_en:', $programNameEn]);
        Log::info('program name tr: ', ['program_name_tr:', $programNameTr]);
        return match ($degreeType) {
            DegreeTypeEnum::BACHELOR => [
                'en' => "This is to certify that has successfully completed all required academic studies in the Bachelor's Program in {$programNameEn} and has qualified to receive the {$degreeNameEn}.",
                'tr' => trim(($facultyNameTr ? $facultyNameTr . ' ' : '') . "{$programNameTr} Lisans Programı'nda gerekli tüm akademik çalışmaları başarıyla tamamlamış ve {$degreeNameTr} almaya hak kazanmıştır."),
            ],
            DegreeTypeEnum::MASTER => [
                'en' => "This is to certify that has successfully completed all required academic studies in the Master's Program with Thesis in {$programNameEn} under the Institute of Graduate Studies, has defended the master's thesis, and has qualified to receive the {$degreeNameEn}.",
                'tr' => "Lisansüstü Eğitim Enstitüsü {$programNameTr} Tezli Yüksek Lisans Programı'nda gerekli tüm akademik çalışmaları başarıyla tamamlamış, yüksek lisans tezini savunmuş ve {$degreeNameTr} almaya hak kazanmıştır.",
            ],
            DegreeTypeEnum::phD => [
                'en' => "This is to certify that has successfully completed all required academic and research studies in the Doctoral Program in {$programNameEn} under the Institute of Graduate Studies, has defended the doctoral dissertation, and has qualified to receive the {$degreeNameEn}.",
                'tr' => "Lisansüstü Eğitim Enstitüsü {$programNameTr} Doktora Programı'nda gerekli tüm akademik ve bilimsel çalışmaları başarıyla tamamlamış, doktora tezini savunmuş ve {$degreeNameTr} almaya hak kazanmıştır.",
            ],
            DegreeTypeEnum::MASTER_WITHOUT_THESIS => [
                'en' => "This is to certify that has successfully completed all required academic studies in the Non-Thesis Master's Program in {$programNameEn} under the Institute of Graduate Studies and has qualified to receive the {$degreeNameEn}.",
                'tr' => "Lisansüstü Eğitim Enstitüsü {$programNameTr} Tezsiz Yüksek Lisans Programı'nda gerekli tüm akademik çalışmaları başarıyla tamamlamış ve {$degreeNameTr} almaya hak kazanmıştır.",
            ],
            default => [
                'en' => "Having successfully completed all the requirements of the\n{$programNameEn} Program\nin the Institute of Graduate Education,\nhas been awarded the {$degreeNameEn} Degree.",
                'tr' => "Lisansüstü Eğitim Enstitüsünde\n{$programNameTr} Programındaki\ntüm yükümlülükleri başarıyla tamamlayarak\n{$degreeNameTr} Derecesini almaya hak kazanmıştır.",
            ],
        };
    }

    public function render()
    {
        return view('livewire.admin.applications.student.show-student');
    }
}
