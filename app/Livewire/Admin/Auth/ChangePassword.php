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
        'current_password.required' => 'Current password is required.',
        'new_password.required' => 'New password is required.',
        'new_password.min' => 'New password must be at least 6 characters long.',
        'new_password.confirmed' => 'New password confirmation does not match.',
        'new_password_confirmation.required' => 'New password confirmation is required.',
    ];

    public function updatePassword()
    {
        $this->validate();

        /** @var \App\Models\User $user */

        $user = Auth::user();

        // Check current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->error = 'Current password is incorrect.';
            $this->success = '';
            return;
        }

        // Check if new password is same as current
        if (Hash::check($this->new_password, $user->password)) {
            $this->error = 'New password must be different from the current password.';
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
        $this->success = 'Password changed successfully.';

        // Reset success message after 3 seconds
        $this->dispatch('password-changed');
    }

    public function render()
    {
        return view('livewire.admin.auth.change-password');
    }
}
