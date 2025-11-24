<?php

namespace App\Livewire\Admin\Faculties;

use App\Models\Faculty;
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
        return view('livewire.admin.faculties.index', [
            'faculties' => Faculty::with('degrees')->paginate(5),
        ]);
    }
}
