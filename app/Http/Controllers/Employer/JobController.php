<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Job::class);

        $jobs = auth()->user()->jobs()->withCount('applications')->latest()->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        Gate::authorize('create', Job::class);

        return view('employer.jobs.create');
    }

    public function store(StoreJobRequest $request)
    {
        Gate::authorize('create', Job::class);

        auth()->user()->jobs()->create($request->validated());

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
    }

    public function show(Job $job)
    {
        Gate::authorize('view', $job);

        $job->load('applications');

        return view('employer.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        Gate::authorize('update', $job);

        return view('employer.jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        Gate::authorize('update', $job);

        $job->update($request->validated());

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        Gate::authorize('delete', $job);

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job removed successfully.');
    }
}
