<?php

namespace App\Http\Controllers\Employer;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApplicantController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Application::class);

        $employer = auth()->user();

        $applications = Application::with(['job.employer', 'jobSeeker'])
            ->whereHas('job', function ($query) use ($employer) {
                $query->where('employer_id', $employer->id);
            })
            ->latest()
            ->paginate(10);

        return view('employer.applicants.index', compact('applications'));
    }

    public function show(Application $application)
    {
        $application->load(['job.employer', 'jobSeeker']);

        Gate::authorize('view', $application);

        return view('employer.applicants.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => ['required', 'in:accepted,refused'],
        ]);

        $application->load(['job', 'jobSeeker']);

        Gate::authorize('update', $application);

        $status = ApplicationStatus::from($request->input('status'));

        if ($application->status === $status) {
            return back()->with('success', 'Application is already ' . $status->value . '.');
        }

        $application->status = $status;
        $application->save();

        $application->jobSeeker->notifications()->create([
            'message' => "Your application for {$application->job->title} has been {$status->value}.",
            'action_url' => route('jobseeker.applications.show', $application),
            'date' => now()->toDateString(),
        ]);

        return back()->with('success', 'Application has been ' . $status->value . '.');
    }
}
