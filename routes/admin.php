<?php

use App\Livewire\Admin\Applications\Agency\Index as AgencyApplicationsIndex;
use App\Livewire\Admin\Applications\Student\Index as StudentApplicationsIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Degrees\Index as DegreesIndex;
use App\Livewire\Admin\Faculties\Index as FacultiesIndex;
use Illuminate\Support\Facades\Route;



Route::name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    
    Route::prefix('faculties')->name('faculties.')->group(function () {
        Route::get('/', FacultiesIndex::class)->name('index');
    });

    Route::prefix('degrees')->name('degrees.')->group(function () {
        Route::get('/', DegreesIndex::class)->name('index');
    });

    Route::prefix('applications')->name('applications.')->group(function () {
        Route::prefix('student')->name('student.')->group(function () {
            Route::get('/', StudentApplicationsIndex::class)->name('index');
        });
        
        Route::prefix('agency')->name('agency.')->group(function () {
            Route::get('/', AgencyApplicationsIndex::class)->name('index');
        });
    });
});
