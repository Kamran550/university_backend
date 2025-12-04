<?php

namespace App\Livewire\Student\Auth;

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
        'email' => 'required',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email və ya istifadəçi adı tələb olunur.',
        'password.required' => 'Şifrə tələb olunur.',
        'password.min' => 'Şifrə ən azı 6 simvol olmalıdır.',
    ];

    public function login()
    {
        $this->validate();

        // Try to find user by email or username
        $user = User::where('email', $this->email)
            ->orWhere('username', $this->email)
            ->first();

        if (!$user) {
            $this->error = 'Email/istifadəçi adı və ya şifrə yanlışdır.';
            return;
        }

        // Check if user has student role (role_id = 3)
        $studentRole = \App\Models\Role::where('name', 'student')->first();
        if ($user->role_id !== ($studentRole?->id ?? 3)) {
            $this->error = 'Bu səhifəyə giriş üçün tələbə hesabı lazımdır.';
            return;
        }

        if (!Hash::check($this->password, $user->password)) {
            $this->error = 'Email/istifadəçi adı və ya şifrə yanlışdır.';
            return;
        }

        Auth::login($user, $this->remember);

        session()->regenerate();

        return $this->redirect(route('student.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.student.auth.login');
    }
}
