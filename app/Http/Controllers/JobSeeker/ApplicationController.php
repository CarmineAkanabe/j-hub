<?php

namespace App\Http\Controllers\JobSeeker;

use App\Enums\ApplicationStatus;
use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Application::class);

        $applications = auth()->user()->applications()->with('job.employer')->latest()->paginate(10);

        return view('jobseeker.applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        $application->load('job.employer');

        Gate::authorize('view', $application);

        return view('jobseeker.applications.show', compact('application'));
    }

    public function store(Job $job)
    {
        Gate::authorize('create', [Application::class, $job]);

        $user = auth()->user();

        if ($user->applications()->where('job_id', $job->id)->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        if ($job->status !== JobStatus::OPEN) {
            return back()->with('error', 'This job is not open for applications.');
        }

        $application = $user->applications()->create([
            'job_id' => $job->id,
            'status' => ApplicationStatus::PENDING,
            'date' => now()->toDateString(),
        ]);

        $employer = $job->employer;
        if ($employer) {
            $employer->notifications()->create([
                'message' => "New application received from {$user->name} for {$job->title}.",
                'action_url' => route('employer.applicants.show', $application),
                'date' => now()->toDateString(),
            ]);
        }

        return back()->with('success', 'Your application has been submitted successfully.');
    }
}
