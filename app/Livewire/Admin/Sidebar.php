<?php

namespace App\Livewire\Admin;

use App\Models\StudentApplication;
use App\Models\AgencyApplication;
use Livewire\Attributes\On;
use Livewire\Component;

class Sidebar extends Component
{
    public $studentCount = 0;
    public $agencyCount = 0;

    public function mount()
    {
        $this->refreshCounts();
    }

    #[On('applicationCreated')]
    public function refreshCounts()
    {
        $this->studentCount = StudentApplication::whereHas('application', function ($query) {
            $query->where('status', 'pending');
        })->count();

        $this->agencyCount = AgencyApplication::whereHas('application', function ($query) {
            $query->where('status', 'pending');
        })->count();
    }

    public function render()
    {
        return view('livewire.admin.sidebar');
    }
}
