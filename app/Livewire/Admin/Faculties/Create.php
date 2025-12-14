<?php

namespace App\Livewire\Admin\Faculties;

use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $name_en = '';
    public string $name_tr = '';

    protected function rules()
    {
        return [
            'name_en' => ['required', 'string', 'max:255', 'unique:faculties,name'],
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

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // Create faculty with EN name in faculties table
            $faculty = Faculty::create([
                'name' => $this->name_en,
            ]);

            // Create EN translation
            $faculty->translations()->create([
                'language' => 'en',
                'name' => $this->name_en,
            ]);

            // Create TR translation
            $faculty->translations()->create([
                'language' => 'tr',
                'name' => $this->name_tr,
            ]);
        });

        Log::info('Creating faculty', [
            'name_en' => $this->name_en,
            'name_tr' => $this->name_tr,
        ]);

        // Reset form
        $this->reset('name_en', 'name_tr');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('faculty-created');
        $this->dispatch('close-modal');
    }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset('name_en', 'name_tr');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.faculties.create');
    }
}
