<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Verify\Verify;
use App\Http\Controllers\FileController;

Route::name('verify.')->group(function () {
    Route::get('/', Verify::class)->name('index');
    Route::get('/document/{code}', [FileController::class, 'verifyDocument'])
        ->where('code', '[A-Za-z0-9]+')
        ->middleware('throttle:30,1')
        ->name('document');
});