<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class ChangePassword extends Component
{
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';
    public $error = '';
    public $success = '';

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
        'new_password_confirmation' => 'required',
    ];

    protected $messages = [
        'current_password.required' => 'Cari şifrə tələb olunur.',
        'new_password.required' => 'Yeni şifrə tələb olunur.',
        'new_password.min' => 'Yeni şifrə ən azı 6 simvol olmalıdır.',
        'new_password.confirmed' => 'Yeni şifrə təsdiqlənmədi.',
        'new_password_confirmation.required' => 'Şifrə təsdiqlənməsi tələb olunur.',
    ];

    public function updatePassword()
    {
        $this->validate();

        /** @var \App\Models\User $user */

        $user = Auth::user();

        // Check current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->error = 'Cari şifrə yanlışdır.';
            $this->success = '';
            return;
        }

        // Check if new password is same as current
        if (Hash::check($this->new_password, $user->password)) {
            $this->error = 'Yeni şifrə cari şifrədən fərqli olmalıdır.';
            $this->success = '';
            return;
        }

        // Update password
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Clear form
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->error = '';
        $this->success = 'Şifrə uğurla dəyişdirildi.';

        // Reset success message after 3 seconds
        $this->dispatch('password-changed');
    }

    public function render()
    {
        return view('livewire.admin.auth.change-password');
    }
}
