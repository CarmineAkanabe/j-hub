<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\JobSeeker\ApplicationController as JobSeekerApplicationController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JobController;
use Illuminate\Support\Facades\Route;

// === Home Route ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/jobs', [EmployerJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [EmployerJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [EmployerJobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}', [EmployerJobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/edit', [EmployerJobController::class, 'edit'])->name('jobs.edit');
    Route::match(['put', 'patch'], '/jobs/{job}', [EmployerJobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [EmployerJobController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/applicants', fn () => view('employer.applicants.index'))->name('applicants.index');
    Route::get('/notifications', fn () => view('employer.notifications.index'))->name('notifications.index');
    Route::get('/profile', fn () => view('employer.profile.edit'))->name('profile');
});

Route::middleware(['auth', 'role:jobseeker'])->prefix('jobseeker')->name('jobseeker.')->group(function () {
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applications', [JobSeekerApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [JobSeekerApplicationController::class, 'show'])->name('applications.show');
    Route::get('/notifications', fn () => view('jobseeker.notifications.index'))->name('notifications.index');
    Route::get('/profile', fn () => view('jobseeker.profile.edit'))->name('profile');
});

// === Auth Routes (Public) ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register/jobseeker', [RegisterController::class, 'showJobSeekerForm'])->name('register.jobseeker.show');
Route::post('/register/jobseeker', [RegisterController::class, 'registerJobSeeker'])->name('register.jobseeker.store');
Route::get('/register/employer', [RegisterController::class, 'showEmployerForm'])->name('register.employer.show');
Route::post('/register/employer', [RegisterController::class, 'registerEmployer'])->name('register.employer.store');


