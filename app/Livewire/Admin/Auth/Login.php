<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function login()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->error = 'Email or password is incorrect.';
            return;
        }

        // Check if user has admin role (role_id = 1)
        if ($user->role_id !== 1) {
            $this->error = 'Admin permission is required to access this page.';
            return;
        }

        if (!Hash::check($this->password, $user->password)) {
            $this->error = 'Email or password is incorrect.';
            return;
        }

        Auth::login($user, $this->remember);

        session()->regenerate();

        return $this->redirect(route('admin.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}

