<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = auth()->user()->applications()->with('job.employer')->latest()->paginate(10);

        return view('jobseeker.applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        $application = auth()->user()->applications()->with('job.employer')->findOrFail($application->id);

        return view('jobseeker.applications.show', compact('application'));
    }
}
