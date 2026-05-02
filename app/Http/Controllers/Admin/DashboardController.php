<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Comment;
use App\Models\Job;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $jobCount = Job::count();
        $applicationCount = Application::count();
        $commentCount = Comment::count();

        return view('admin.dashboard', compact('userCount', 'jobCount', 'applicationCount', 'commentCount'));
    }
}
