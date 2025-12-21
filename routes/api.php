<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\FacultyController;
use App\Http\Controllers\API\v1\DegreeController;
use App\Http\Controllers\API\v1\ProgramController;
use App\Http\Controllers\API\v1\ApplicationController;

Route::prefix('v1')->group(function () {
    Route::get('/faculties', [FacultyController::class, 'index']);
    Route::get('/degrees', [DegreeController::class, 'index']);
    Route::get('/degrees/{id}', [DegreeController::class, 'show']);
    Route::get('/faculties/{id}', [FacultyController::class, 'show']);
    
    // Program routes
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/programs/filter', [ProgramController::class, 'filter']);
    Route::get('/programs/{id}', [ProgramController::class, 'show']);
    
    // Application routes
    Route::post('/applications/student', [ApplicationController::class, 'storeStudent']);
    Route::post('/applications/agency', [ApplicationController::class, 'storeAgency']);
    Route::post('/applications/transfer', [ApplicationController::class, 'storeTransfer']);
});

