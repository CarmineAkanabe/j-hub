<?php

namespace App\Http\Controllers\Employer;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
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
        $employer = auth()->user();

        $application = Application::with(['job.employer', 'jobSeeker'])
            ->whereHas('job', function ($query) use ($employer) {
                $query->where('employer_id', $employer->id);
            })
            ->findOrFail($application->id);

        return view('employer.applicants.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => ['required', 'in:accepted,refused'],
        ]);

        $employer = auth()->user();

        $application = Application::where('id', $application->id)
            ->whereHas('job', function ($query) use ($employer) {
                $query->where('employer_id', $employer->id);
            })
            ->firstOrFail();

        $status = ApplicationStatus::from($request->input('status'));

        if ($application->status === $status) {
            return back()->with('success', 'Application is already ' . $status->value . '.');
        }

        $application->status = $status;
        $application->save();

        $application->jobSeeker->notifications()->create([
            'message' => "Your application for {$application->job->title} has been {$status->value}.",
            'date' => now()->toDateString(),
        ]);

        return back()->with('success', 'Application has been ' . $status->value . '.');
    }
}
