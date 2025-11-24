<?php

use App\Livewire\Student\Dashboard;
use Illuminate\Support\Facades\Route;


Route::get('/', Dashboard::class)->name('student.dashboard');