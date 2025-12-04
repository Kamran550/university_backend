<?php

use App\Livewire\Student\Dashboard;
use App\Livewire\Student\Auth\Login;
use App\Livewire\Student\Profil;
use Illuminate\Support\Facades\Route;

// Login route (without middleware)

// Protected routes (with student middleware)
Route::name('student.')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::middleware('student')->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/profile', Profil::class)->name('profile');
    });
});