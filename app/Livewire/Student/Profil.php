<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.student')]
class Profil extends Component
{
    use WithFileUploads;

    public $name = '';
    public $surname = '';
    public $email = '';
    public $username = '';
    public $phone = '';
    public $profile_photo;
    public $profile_photo_preview = '';

    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    public $error = '';
    public $success = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'username' => 'required|string|max:255',
        'phone' => 'nullable|string|max:255',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'current_password' => 'required_with:new_password',
        'new_password' => 'nullable|min:6|confirmed',
        'new_password_confirmation' => 'required_with:new_password',
    ];

    protected $messages = [
        'name.required' => 'Name is required.',
        'surname.required' => 'Surname is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Enter a valid email address.',
        'username.required' => 'Username is required.',
        'profile_photo.image' => 'Only image files are accepted.',
        'profile_photo.mimes' => 'Only JPG, JPEG and PNG formats are allowed.',
        'profile_photo.max' => 'Image size must be less than 2MB.',
        'current_password.required_with' => 'To change password, current password is required.',
        'new_password.min' => 'New password must be at least 6 characters long.',
        'new_password.confirmed' => 'New password confirmation does not match.',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->phone = $user->phone;

        if ($user->profile_photo) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = Storage::disk('do_spaces');
            $this->profile_photo_preview = $disk->url($user->profile_photo);
        } else {
            $this->profile_photo_preview = '';
        }
    }

    public function updatedProfilePhoto()
    {
        Log::info('Profile photo updated', ['file' => $this->profile_photo]);

        try {
            $this->validateOnly('profile_photo');
            Log::info('Validation passed');
        } catch (\Exception $e) {
            Log::error('Validation failed', ['error' => $e->getMessage()]);
            $this->error = 'File validation failed: ' . $e->getMessage();
        }
    }

    public function updateProfile()
    {
        Log::info('updateProfile called', [
            'has_photo' => !is_null($this->profile_photo),
            'photo_type' => gettype($this->profile_photo)
        ]);

        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
                'phone' => 'nullable|string|max:255',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            $this->error = implode(' ', array_map(fn($errors) => implode(' ', $errors), $e->errors()));
            return;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $updateData = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
        ];

        // Handle profile photo upload
        if ($this->profile_photo) {
            try {
                Log::info('Processing profile photo', [
                    'original_name' => $this->profile_photo->getClientOriginalName(),
                    'size' => $this->profile_photo->getSize(),
                    'mime' => $this->profile_photo->getMimeType()
                ]);

                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('do_spaces');

                // Delete old photo if exists
                if ($user->profile_photo && $disk->exists($user->profile_photo)) {
                    Log::info('Deleting old photo', ['path' => $user->profile_photo]);
                    $disk->delete($user->profile_photo);
                }

                // Store new photo in DigitalOcean Spaces
                $path = $this->profile_photo->store('users/profile-photos', 'do_spaces');
                Log::info('Photo stored successfully', ['path' => $path]);

                $updateData['profile_photo'] = $path;
                $this->profile_photo_preview = $disk->url($path);
            } catch (\Exception $e) {
                Log::error('Failed to upload photo', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $this->error = 'Failed to upload photo: ' . $e->getMessage();
                return;
            }
        }

        // Update password if provided
        if ($this->new_password) {
            $this->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            if (!Hash::check($this->current_password, $user->password)) {
                $this->error = 'Current password is incorrect.';
                $this->success = '';
                return;
            }

            if (Hash::check($this->new_password, $user->password)) {
                $this->error = 'New password must be different from the current password.';
                $this->success = '';
                return;
            }

            $updateData['password'] = Hash::make($this->new_password);
        }

        try {
            User::where('id', $user->id)->update($updateData);
            Log::info('Profile updated successfully', ['user_id' => $user->id, 'data' => $updateData]);

            // Clear fields
            $this->profile_photo = null;
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
            $this->error = '';
            $this->success = 'Profile updated successfully.';
        } catch (\Exception $e) {
            Log::error('Failed to update profile', ['error' => $e->getMessage()]);
            $this->error = 'Failed to update profile: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.student.profil');
    }
}
