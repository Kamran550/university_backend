<?php

namespace App\Livewire\Admin\Applications\Agency;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\AgencyApplication;

#[Layout('layouts.admin')]
class ShowAgency extends Component
{
    public AgencyApplication $agency;

    public function mount(AgencyApplication $agency): void
    {
        $this->agency = $agency->load('application');
    }

    public function render()
    {
        return view('livewire.admin.applications.agency.show-agency');
    }
}
