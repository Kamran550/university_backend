<?php

use Illuminate\Support\Facades\Route;


Route::domain('admin.eipu.edu.pl')->group(function () {
    require base_path('routes/admin.php');
});


Route::domain('teacher.eipu.edu.pl')->group(function () {
    require base_path('routes/teacher.php');
});


Route::domain('student.eipu.edu.pl')->group(function () {
    require base_path('routes/student.php');
});


Route::domain('verify.eipu.edu.pl')->group(function () {
    require base_path(path: 'routes/verify.php');
});