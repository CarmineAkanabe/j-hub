<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JobController;
use Illuminate\Support\Facades\Route;

// === Home Route ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// === Auth Routes (Public) ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register/jobseeker', [RegisterController::class, 'showJobSeekerForm'])->name('register.jobseeker.show');
Route::post('/register/jobseeker', [RegisterController::class, 'registerJobSeeker'])->name('register.jobseeker.store');
Route::get('/register/employer', [RegisterController::class, 'showEmployerForm'])->name('register.employer.show');
Route::post('/register/employer', [RegisterController::class, 'registerEmployer'])->name('register.employer.store');


