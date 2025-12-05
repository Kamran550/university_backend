<?php

use App\Livewire\Admin\Applications\Agency\Index as AgencyApplicationsIndex;
use App\Livewire\Admin\Applications\Student\Index as StudentApplicationsIndex;
use App\Livewire\Admin\Applications\Student\ShowStudent;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Degrees\Index as DegreesIndex;
use App\Livewire\Admin\Degrees\Create as DegreesCreate;
use App\Livewire\Admin\Faculties\Index as FacultiesIndex;
use App\Livewire\Admin\Programs\Index as ProgramsIndex;
use App\Livewire\Admin\Students\Index as StudentsIndex;
use App\Livewire\Admin\Students\Show as StudentsShow;
use App\Livewire\Admin\Teachers\Index as TeachersIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Applications\Agency\ShowAgency;



Route::name('admin.')->group(function () {
    // Login route (without middleware)
    Route::get('/login', \App\Livewire\Admin\Auth\Login::class)->name('login');
    Route::post('/logout', \App\Livewire\Admin\Auth\Logout::class)->name('logout')->middleware('admin');
    
    // Protected routes (with admin middleware)
    Route::middleware('admin')->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');
        
        // Change Password
        Route::get('/change-password', \App\Livewire\Admin\Auth\ChangePassword::class)->name('change-password');
    
    Route::prefix('faculties')->name('faculties.')->group(function () {
        Route::get('/', FacultiesIndex::class)->name('index');
    });

    Route::prefix('degrees')->name('degrees.')->group(function () {
        Route::get('/', DegreesIndex::class)->name('index');
        Route::get('/create', DegreesCreate::class)->name('create');
    });

    Route::prefix('programs')->name('programs.')->group(function () {
        Route::get('/', ProgramsIndex::class)->name('index');
    });

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', StudentsIndex::class)->name('index');
        Route::get('/{student}', StudentsShow::class)->name('show');
    });

    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', TeachersIndex::class)->name('index');
    });

    Route::prefix('applications')->name('applications.')->group(function () {
        Route::prefix('student')->name('student.')->group(function () {
            Route::get('/', StudentApplicationsIndex::class)->name('index');
            Route::get('/{student}', ShowStudent::class)->name('show');
        });
        
        Route::prefix('agency')->name('agency.')->group(function () {
            Route::get('/', AgencyApplicationsIndex::class)->name('index');
            Route::get('/{agency}', ShowAgency::class)->name('show');
        });
    });
    });
});
