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
        $employerCount = User::where('role', UserRole::EMPLOYER)->count();
        $jobSeekerCount = User::where('role', UserRole::JOBSEEKER)->count();
        $chartMax = max($employerCount, $jobSeekerCount, 1);
        $roleChartData = [
            [
                'label' => 'Employers',
                'value' => $employerCount,
                'width' => round(($employerCount / $chartMax) * 100),
            ],
            [
                'label' => 'Job Seekers',
                'value' => $jobSeekerCount,
                'width' => round(($jobSeekerCount / $chartMax) * 100),
            ],
        ];

        return view(
            'admin.dashboard',
            compact('userCount', 'jobCount', 'applicationCount', 'commentCount', 'roleChartData')
        );
    }
}
