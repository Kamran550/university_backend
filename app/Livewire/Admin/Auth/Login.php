<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;
use App\Services\AdminTwoFactorService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $error = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email address is required.',
        'email.email' => 'Enter a valid email address.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters long.',
    ];

    protected AdminTwoFactorService $twoFactor;

    public function boot(AdminTwoFactorService $twoFactor)
    {
        $this->twoFactor = $twoFactor;
    }

    public function mount()
    {
        // Show messages flashed by AdminMiddleware / 2FA screen
        $this->error = session('error', '');
    }

    public function login()
    {
        $this->validate();

        $throttleKey = 'admin-login:' . Str::lower($this->email) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->error = "Too many login attempts. Please try again in {$seconds} seconds.";
            return;
        }

        $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            RateLimiter::hit($throttleKey, 300);
            $this->error = 'Email or password is incorrect.';
            return;
        }

        // Check if user has admin role (role_id = 1)
        if ($user->role_id !== 1) {
            RateLimiter::hit($throttleKey, 300);
            $this->error = 'Admin permission is required to access this page.';
            return;
        }

        RateLimiter::clear($throttleKey);

        // Password is correct, but the user is NOT logged in until the
        // Google Authenticator code is verified on the next screen.
        $this->twoFactor->startPendingLogin($user, $this->remember);

        $this->reset('password');

        return $this->redirect(route('admin.two-factor'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}

