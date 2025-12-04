<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Program;
use App\Models\Application;
use App\Enums\ApplicationStatusEnum;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        // Get role IDs
        $studentRole = Role::where('name', 'student')->first();
        $teacherRole = Role::where('name', 'teacher')->first();

        // Calculate statistics
        $studentsCount = User::where('role_id', $studentRole?->id ?? 3)->count();
        $teachersCount = User::where('role_id', $teacherRole?->id ?? 2)->count();
        $programsCount = Program::count();
        $applicationsCount = Application::count();
        $pendingApplicationsCount = Application::where('status', ApplicationStatusEnum::PENDING)->count();

        return view('livewire.admin.dashboard', [
            'studentsCount' => $studentsCount,
            'teachersCount' => $teachersCount,
            'programsCount' => $programsCount,
            'applicationsCount' => $applicationsCount,
            'pendingApplicationsCount' => $pendingApplicationsCount,
        ]);
    }
}
