<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured jobs.
     */
    public function index()
    {
        // Get featured jobs (open jobs, ordered by creation date)
        $featuredJobs = Job::where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('public.home', compact('featuredJobs'));
    }
}
