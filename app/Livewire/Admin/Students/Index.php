<?php

namespace App\Livewire\Admin\Students;

use App\Models\User;
use App\Models\Role;
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

    #[Url(as: 'search')]
    public string $search = '';

    public $queryString = ['page', 'search'];

    protected function getPageName()
    {
        return 'page';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function render()
    {
        $studentRole = Role::where('name', 'student')->first();
        
        $query = User::with('role')
            ->where('role_id', $studentRole?->id ?? 3);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('surname', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.students.index', [
            'students' => $students,
        ]);
    }
}
