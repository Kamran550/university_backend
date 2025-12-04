<?php

namespace App\Livewire\Student\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('student.login');
    }

    public function render()
    {
        return view('livewire.student.auth.logout');
    }
}

