<?php

namespace App\Livewire\Admin\Applications\Agency;

use App\Models\AgencyApplication;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'page')]
    public int $page = 1;

    public $queryString = ['page'];

    protected function getPageName()
    {
        return 'page';
    }

    public function updatingPage()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        return view('livewire.admin.applications.agency.index', [
            'applications' => AgencyApplication::with('application')->paginate(10),
        ]);
    }
}
