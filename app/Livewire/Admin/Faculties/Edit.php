<?php

namespace App\Livewire\Admin\Faculties;

use App\Models\Faculty;
use App\Models\FacultyTranslation;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    public ?Faculty $faculty = null;
    public string $name_en = '';
    public string $name_tr = '';

    public function mount(?Faculty $faculty = null)
    {
        $this->faculty = $faculty;
        if ($faculty) {
            $this->faculty->load('translations');
            $this->loadFacultyData($this->faculty);
        }
    }

    #[On('edit-faculty')]
    public function loadFaculty($facultyId)
    {
        $this->faculty = Faculty::with('translations')->findOrFail($facultyId);
        $this->loadFacultyData($this->faculty);
        $this->resetValidation();
    }

    protected function loadFacultyData(Faculty $faculty)
    {
        // Load translations (case-insensitive)
        $enTranslation = $faculty->translations->filter(function ($translation) {
            return strtolower($translation->language) === 'en';
        })->first();
        $trTranslation = $faculty->translations->filter(function ($translation) {
            return strtolower($translation->language) === 'tr';
        })->first();
        
        $this->name_en = $enTranslation?->name ?? $faculty->name ?? '';
        $this->name_tr = $trTranslation?->name ?? '';
    }

    protected function rules()
    {
        return [
            'name_en' => ['required', 'string', 'max:255', 'unique:faculties,name,' . ($this->faculty?->id ?? 0)],
            'name_tr' => ['required', 'string', 'max:255'],
        ];
    }

    protected function messages()
    {
        return [
            'name_en.required' => 'Fakültə adı (EN) mütləqdir.',
            'name_en.unique' => 'Bu fakültə adı (EN) artıq mövcuddur.',
            'name_en.max' => 'Fakültə adı (EN) maksimum 255 simvol ola bilər.',
            'name_tr.required' => 'Fakültə adı (TR) mütləqdir.',
            'name_tr.max' => 'Fakültə adı (TR) maksimum 255 simvol ola bilər.',
        ];
    }

    public function update()
    {
        if (!$this->faculty) {
            return;
        }

        $this->validate();

        DB::transaction(function () {
            // Update faculties table with EN name
            $this->faculty->update([
                'name' => $this->name_en,
            ]);

            // Update or create EN translation (case-insensitive search)
            $enTranslation = $this->faculty->translations()
                ->whereRaw('LOWER(language) = ?', ['en'])
                ->first();
            if ($enTranslation) {
                $enTranslation->update(['name' => $this->name_en]);
            } else {
                $this->faculty->translations()->create([
                    'language' => 'en',
                    'name' => $this->name_en,
                ]);
            }

            // Update or create TR translation (case-insensitive search)
            $trTranslation = $this->faculty->translations()
                ->whereRaw('LOWER(language) = ?', ['tr'])
                ->first();
            if ($trTranslation) {
                $trTranslation->update(['name' => $this->name_tr]);
            } else {
                $this->faculty->translations()->create([
                    'language' => 'tr',
                    'name' => $this->name_tr,
                ]);
            }
        });

        Log::info('Updating faculty', [
            'name_en' => $this->name_en,
            'name_tr' => $this->name_tr,
        ]);

        // Reset form
        $this->reset('name_en', 'name_tr');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('faculty-updated');
        $this->dispatch('close-edit-modal');
    }

    #[On('reset-edit-form')]
    public function resetForm()
    {
        if ($this->faculty) {
            $this->loadFacultyData($this->faculty);
        }
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.faculties.edit');
    }
}
