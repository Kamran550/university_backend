<?php

namespace App\Livewire\Admin\Degrees;

use App\Models\Degree;
use Livewire\Component;
use Livewire\Attributes\On;

class Delete extends Component
{
    public ?Degree $degree = null;

    public function mount(?Degree $degree = null)
    {
        $this->degree = $degree;
    }

    #[On('delete-degree')]
    public function loadDegree($degreeId)
    {
        $this->degree = Degree::findOrFail($degreeId);
    }

    public function delete()
    {
        if (!$this->degree) {
            return;
        }

        $this->degree->delete();

        // Reset
        $this->reset('degree');

        // Dispatch event to close modal and refresh list
        $this->dispatch('degree-deleted');
        $this->dispatch('close-delete-modal');
    }

    public function render()
    {
        return view('livewire.admin.degrees.delete');
    }
}
