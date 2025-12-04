<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

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
        'profile_photo' => 'nullable|image|max:2048',
        'current_password' => 'required_with:new_password',
        'new_password' => 'nullable|min:6|confirmed',
        'new_password_confirmation' => 'required_with:new_password',
    ];

    protected $messages = [
        'name.required' => 'Ad tələb olunur.',
        'surname.required' => 'Soyad tələb olunur.',
        'email.required' => 'Email tələb olunur.',
        'email.email' => 'Düzgün email ünvanı daxil edin.',
        'username.required' => 'İstifadəçi adı tələb olunur.',
        'profile_photo.image' => 'Yalnız şəkil faylları qəbul olunur.',
        'profile_photo.max' => 'Şəkil ölçüsü 2MB-dan çox ola bilməz.',
        'current_password.required_with' => 'Şifrə dəyişdirmək üçün cari şifrə tələb olunur.',
        'new_password.min' => 'Yeni şifrə ən azı 6 simvol olmalıdır.',
        'new_password.confirmed' => 'Yeni şifrə təsdiqlənmədi.',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->profile_photo_preview = $user->profile_photo ? asset('storage/' . $user->profile_photo) : '';
    }

    public function updatedProfilePhoto()
    {
        $this->validateOnly('profile_photo');
        // JavaScript preview istifadə edirik, buna görə burada preview yaratmağa ehtiyac yoxdur
        // Amma validation üçün saxlayırıq
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'phone' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

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
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $path = $this->profile_photo->store('profile-photos', 'public');
            $updateData['profile_photo'] = $path;
            $this->profile_photo_preview = asset('storage/' . $path);
        }

        // Update password if provided
        if ($this->new_password) {
            $this->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            if (!Hash::check($this->current_password, $user->password)) {
                $this->error = 'Cari şifrə yanlışdır.';
                $this->success = '';
                return;
            }

            if (Hash::check($this->new_password, $user->password)) {
                $this->error = 'Yeni şifrə cari şifrədən fərqli olmalıdır.';
                $this->success = '';
                return;
            }

            $updateData['password'] = Hash::make($this->new_password);
        }

        User::where('id', $user->id)->update($updateData);

        // Clear fields
        $this->profile_photo = null;
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->error = '';
        $this->success = 'Profil uğurla yeniləndi.';
    }

    public function render()
    {
        return view('livewire.student.profil');
    }
}
