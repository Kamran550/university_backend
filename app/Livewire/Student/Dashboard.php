<?php

namespace App\Livewire\Student;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.student')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Get student's application with all related data
        $application = Application::with([
            'program.degree',
            'program.faculty',
            'studentApplication'
        ])
        ->where('user_id', $user->id)
        ->latest()
        ->first();

        return view('livewire.student.dashboard', [
            'application' => $application,
            'user' => $user,
        ]);
    }
}
