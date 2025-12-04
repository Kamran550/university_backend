<?php

namespace App\Livewire\Admin\Applications\Student;

use App\Enums\ApplicationStatusEnum;
use App\Mail\AcceptanceLetterMail;
use App\Mail\FinalAcceptanceLetterMail;
use App\Models\StudentApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ShowStudent extends Component
{
    public StudentApplication $student;

    public function mount(StudentApplication $student): void
    {
        $this->student = $student->load('application');
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
            
            if ($mailDriver === 'log') {
                session()->flash('success', 'Mail log faylına yazıldı. SMTP konfiqurasiyası üçün .env faylında MAIL_MAILER=smtp təyin edin.');
            } else {
                session()->flash('success', 'Şərtli qəbul məktubu ' . $this->student->email . ' ünvanına göndərildi.');
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
            $this->student->load('application');

            // Check if user already exists
            $user = User::where('email', $this->student->email)->first();

            if (!$user) {
                // Create new user
                $user = DB::transaction(function () {
                    // Generate username from email or create unique username
                    // $baseUsername = Str::before($this->student->email, '@');
                    // $username = $baseUsername;
                    // $counter = 1;
                    
                    // while (User::where('username', $username)->exists()) {
                    //     $username = $baseUsername . $counter;
                    //     $counter++;
                    // }

                    // Generate random password
                    $password = Str::random(12);
                    Log::info('Password: ' . $password);

                    // Get student role (assuming role_id 3 is for students, adjust as needed)
                    // If roles table doesn't have student role, you may need to create it or use null

                    $user = User::create([
                        'name' => $this->student->first_name,
                        'surname' => $this->student->last_name,
                        'email' => $this->student->email,
                        'username' => $this->student->student_number,
                        'phone' => $this->student->phone,
                        'password' => Hash::make($password),
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
            
            Mail::to($this->student->email)->send(new FinalAcceptanceLetterMail($this->student, $user));
            
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

    public function render()
    {
        return view('livewire.admin.applications.student.show-student');
    }
}
