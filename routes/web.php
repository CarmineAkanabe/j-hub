<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// === Auth Routes (Public) ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register/jobseeker', [RegisterController::class, 'showJobSeekerForm'])->name('register.jobseeker.show');
Route::post('/register/jobseeker', [RegisterController::class, 'registerJobSeeker'])->name('register.jobseeker.store');
Route::get('/register/employer', [RegisterController::class, 'showEmployerForm'])->name('register.employer.show');
Route::post('/register/employer', [RegisterController::class, 'registerEmployer'])->name('register.employer.store');


