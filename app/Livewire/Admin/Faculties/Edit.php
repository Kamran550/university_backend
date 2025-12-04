<?php

namespace App\Livewire\Admin\Faculties;

use App\Models\Faculty;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public ?Faculty $faculty = null;
    public string $name = '';

    public function mount(?Faculty $faculty = null)
    {
        $this->faculty = $faculty;
        $this->name = $faculty->name ?? '';
    }

    #[On('edit-faculty')]
    public function loadFaculty($facultyId)
    {
        $this->faculty = Faculty::findOrFail($facultyId);
        $this->name = $this->faculty->name;
        $this->resetValidation();
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:faculties,name,' . ($this->faculty?->id ?? 0)],
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Fakültə adı mütləqdir.',
            'name.unique' => 'Bu fakültə adı artıq mövcuddur.',
            'name.max' => 'Fakültə adı maksimum 255 simvol ola bilər.',
        ];
    }

    public function update()
    {
        if (!$this->faculty) {
            return;
        }

        $this->validate();

        $this->faculty->update([
            'name' => $this->name,
        ]);

        // Reset form
        $this->reset('name');
        $this->resetValidation();

        // Dispatch event to close modal and refresh list
        $this->dispatch('faculty-updated');
        $this->dispatch('close-edit-modal');
    }

    #[On('reset-edit-form')]
    public function resetForm()
    {
        if ($this->faculty) {
            $this->name = $this->faculty->name;
        }
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.faculties.edit');
    }
}
