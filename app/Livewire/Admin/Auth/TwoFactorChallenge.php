<?php

namespace App\Livewire\Admin\Auth;

use App\Services\AdminTwoFactorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class TwoFactorChallenge extends Component
{
    public $code = '';
    public $error = '';

    // NOTE: the secret / QR code must never be a public property,
    // public properties are sent to the browser in the Livewire snapshot.
    protected AdminTwoFactorService $twoFactor;

    protected $rules = [
        'code' => 'required|digits:6',
    ];

    protected $messages = [
        'code.required' => 'Verification code is required.',
        'code.digits' => 'The code must be 6 digits.',
    ];

    public function boot(AdminTwoFactorService $twoFactor)
    {
        $this->twoFactor = $twoFactor;
    }

    public function mount()
    {
        if (!$this->twoFactor->pendingUser()) {
            return $this->redirect(route('admin.login'));
        }
    }

    public function verify()
    {
        $this->code = preg_replace('/\s+/', '', (string) $this->code);

        $this->validate();

        $user = $this->twoFactor->pendingUser();

        if (!$user) {
            session()->flash('error', 'Your session has expired. Please log in again.');
            return $this->redirect(route('admin.login'));
        }

        $throttleKey = $this->twoFactor->throttleKey($user);

        if (RateLimiter::tooManyAttempts($throttleKey, AdminTwoFactorService::THROTTLE_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->error = "Too many attempts. Please try again in {$seconds} seconds.";
            $this->code = '';
            return;
        }

        if (!$this->twoFactor->verifyCode($user, $this->code)) {
            RateLimiter::hit($throttleKey, AdminTwoFactorService::THROTTLE_DECAY_SECONDS);
            $attempts = $this->twoFactor->registerFailedAttempt();
            $this->code = '';

            Log::warning('Admin 2FA: invalid code', [
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'attempt' => $attempts,
            ]);

            if ($attempts >= AdminTwoFactorService::MAX_ATTEMPTS) {
                $this->twoFactor->clearPending();
                session()->flash('error', 'Too many invalid codes. Please log in again.');
                return $this->redirect(route('admin.login'));
            }

            $this->error = 'Invalid verification code.';
            return;
        }

        RateLimiter::clear($throttleKey);

        if (!$user->hasEnabledTwoFactor()) {
            $this->twoFactor->confirm($user);
            Log::info('Admin 2FA: setup completed', ['user_id' => $user->id, 'ip' => request()->ip()]);
        }

        $this->twoFactor->completeLogin($user);

        return $this->redirect(route('admin.dashboard'), navigate: true);
    }

    public function cancel()
    {
        $this->twoFactor->clearPending();

        return $this->redirect(route('admin.login'));
    }

    public function render()
    {
        $user = $this->twoFactor->pendingUser();
        $setupMode = $user && !$user->hasEnabledTwoFactor();

        return view('livewire.admin.auth.two-factor-challenge', [
            'setupMode' => $setupMode,
            'qrCodeSvg' => $setupMode ? $this->twoFactor->qrCodeSvg($user) : null,
        ]);
    }
}
