<?php

use App\Livewire\Teacher\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('teacher.dashboard');

