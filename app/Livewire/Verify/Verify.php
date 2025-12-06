<?php

namespace App\Livewire\Verify;

use Illuminate\Support\Facades\Storage;
use App\Models\DocumentVerification;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.verify')]
class Verify extends Component
{
    public $verificationCode = '';
    public $message = '';
    public $messageType = ''; // 'success' or 'error'
    public $application = null;

    /**
     * Mount the component and check for verification code in query parameter
     */
    public function mount()
    {
        // Check if verification code is provided in query parameter (for QR code scanning)
        $queryCode = request()->query('verificationcode');
        
        if ($queryCode) {
            $this->verificationCode = strtoupper(trim($queryCode));
            // Automatically verify if code is provided in URL
            $this->verify();
        }
    }

    public function verify()
    {
        $this->reset(['message', 'messageType', 'application']);

        if (empty($this->verificationCode)) {
            $this->message = 'Zəhmət olmasa təsdiqlənmə kodunu daxil edin.';
            $this->messageType = 'error';
            return;
        }

        $verificationCode = strtoupper(trim($this->verificationCode));

        // Find application by verification code
        // $application = Application::where('verification_code', $verificationCode)->first();
        $application = DocumentVerification::where('verification_code', $verificationCode)->first();

        if (!$application) {
            $this->message = 'Yanlış təsdiqlənmə kodu. Zəhmət olmasa yenidən yoxlayın.';
            $this->messageType = 'error';
            return;
        }

        $this->application = $application;
        
        $this->message = 'Təsdiqlənmə uğurlu oldu!';
        $this->messageType = 'success';
    }

    public function getPdfUrl()
    {
        if (!$this->application || !$this->application->file_path) {
            return null;
        }

        if (!Storage::exists($this->application->file_path)) {
            return null;
        }

        return Storage::url($this->application->file_path);
    }

    public function render()
    {
        return view('livewire.verify.verify');
    }
}

