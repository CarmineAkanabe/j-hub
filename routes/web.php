<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LogController as AdminLogController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Employer\ApplicantController as EmployerApplicantController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\Employer\NotificationController as EmployerNotificationController;
use App\Http\Controllers\Employer\ProfileController as EmployerProfileController;
use App\Http\Controllers\JobSeeker\ApplicationController as JobSeekerApplicationController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\NotificationController as JobSeekerNotificationController;
use App\Http\Controllers\JobSeeker\ProfileController as JobSeekerProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JobController;
use Illuminate\Support\Facades\Route;

// === Home Route ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
Route::middleware(['auth', 'role:jobseeker'])->group(function () {
    Route::post('/jobs/{job}/apply', [JobSeekerApplicationController::class, 'store'])->name('jobs.apply');
    Route::post('/jobs/{job}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::middleware(['auth', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/jobs', [EmployerJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [EmployerJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [EmployerJobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}', [EmployerJobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/edit', [EmployerJobController::class, 'edit'])->name('jobs.edit');
    Route::match(['put', 'patch'], '/jobs/{job}', [EmployerJobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [EmployerJobController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/applicants', [EmployerApplicantController::class, 'index'])->name('applicants.index');
    Route::get('/applicants/{application}', [EmployerApplicantController::class, 'show'])->name('applicants.show');
    Route::patch('/applicants/{application}/status', [EmployerApplicantController::class, 'updateStatus'])->name('applicants.updateStatus');
    Route::get('/notifications', [EmployerNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/profile', [EmployerProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [EmployerProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:jobseeker'])->prefix('jobseeker')->name('jobseeker.')->group(function () {
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applications', [JobSeekerApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [JobSeekerApplicationController::class, 'show'])->name('applications.show');
    Route::get('/notifications', [JobSeekerNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/profile', [JobSeekerProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [JobSeekerProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');
});

// === Auth Routes (Public) ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register/jobseeker', [RegisterController::class, 'showJobSeekerForm'])->name('register.jobseeker.show');
Route::post('/register/jobseeker', [RegisterController::class, 'registerJobSeeker'])->name('register.jobseeker.store');
Route::get('/register/employer', [RegisterController::class, 'showEmployerForm'])->name('register.employer.show');
Route::post('/register/employer', [RegisterController::class, 'registerEmployer'])->name('register.employer.store');


