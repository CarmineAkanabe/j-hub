<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the home page with featured jobs, or redirect authenticated users to their dashboard.
     */
    public function index()
    {
        // If user is authenticated, redirect to their role-specific dashboard
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->isEmployer()) {
                return redirect()->route('employer.dashboard');
            } elseif ($user->isJobSeeker()) {
                return redirect()->route('jobseeker.dashboard');
            } elseif ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }
        }

        // Get featured jobs (open jobs, ordered by creation date)
        $featuredJobs = Job::with('employer')
            ->where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $stats = [
            'openJobs' => Job::where('status', 'open')->count(),
            'employers' => User::where('role', 'employer')->count(),
            'applications' => Application::count(),
        ];

        return view('public.home', compact('featuredJobs', 'stats'));
    }
}
