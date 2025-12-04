<?php

namespace App\Livewire\Admin\Faculties;

use Livewire\Component;
use App\Models\Faculty;
use Livewire\Attributes\On;

class Delete extends Component
{
    
    public ?Faculty $faculty = null;

    public function mount(?Faculty $faculty = null)
    {
        $this->faculty = $faculty;
    }

    #[On('delete-faculty')]
    public function loadFaculty($facultyId)
    {
        $this->faculty = Faculty::findOrFail($facultyId);
    }

    public function delete()
    {
        if (!$this->faculty) {
            return;
        }

        $this->faculty->delete();

        // Reset
        $this->reset('faculty');

        // Dispatch event to close modal and refresh list
        $this->dispatch('faculty-deleted');
        $this->dispatch('close-delete-modal');
    }

    public function render()
    {
        return view('livewire.admin.faculties.delete');
    }
}
