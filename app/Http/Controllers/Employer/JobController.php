<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = auth()->user()->jobs()->withCount('applications')->latest()->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(StoreJobRequest $request)
    {
        auth()->user()->jobs()->create($request->validated());

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
    }

    public function show(Job $job)
    {
        $job = auth()->user()->jobs()->with('applications')->findOrFail($job->id);

        return view('employer.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $job = auth()->user()->jobs()->findOrFail($job->id);

        return view('employer.jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $job = auth()->user()->jobs()->findOrFail($job->id);
        $job->update($request->validated());

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job = auth()->user()->jobs()->findOrFail($job->id);
        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job removed successfully.');
    }
}
