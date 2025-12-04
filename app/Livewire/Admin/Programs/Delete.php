<?php

namespace App\Livewire\Admin\Programs;

use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\On;

class Delete extends Component
{
    public ?Program $program = null;

    public function mount(?Program $program = null)
    {
        $this->program = $program;
    }

    #[On('delete-program')]
    public function loadProgram($programId)
    {
        $this->program = Program::findOrFail($programId);
    }

    public function delete()
    {
        if (!$this->program) {
            return;
        }

        $this->program->delete();

        // Reset
        $this->reset('program');

        // Dispatch event to close modal and refresh list
        $this->dispatch('program-deleted');
        $this->dispatch('close-delete-modal');
    }

    public function render()
    {
        return view('livewire.admin.programs.delete');
    }
}
