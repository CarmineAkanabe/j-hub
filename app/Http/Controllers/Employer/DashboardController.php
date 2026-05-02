<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employer = auth()->user();
        $jobCount = $employer->jobs()->count();
        $applicationsCount = Application::whereIn('job_id', $employer->jobs()->pluck('id'))->count();
        $recentJobs = $employer->jobs()->withCount('applications')->latest()->take(5)->get();
        $chartMax = max($jobCount, $applicationsCount, 1);
        $chartData = [
            [
                'label' => 'Jobs Posted',
                'value' => $jobCount,
                'width' => round(($jobCount / $chartMax) * 100),
            ],
            [
                'label' => 'Applications Received',
                'value' => $applicationsCount,
                'width' => round(($applicationsCount / $chartMax) * 100),
            ],
        ];

        return view('employer.dashboard', compact('jobCount', 'applicationsCount', 'recentJobs', 'chartData'));
    }
}
