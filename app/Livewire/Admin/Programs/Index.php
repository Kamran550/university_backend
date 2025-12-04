<?php

namespace App\Livewire\Admin\Programs;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use App\Models\Program;

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
        return view('livewire.admin.programs.index', [
            'programs' => Program::with(['degree', 'faculty'])->paginate(5),
        ]);
    }
}
