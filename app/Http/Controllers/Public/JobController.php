<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $location = $request->query('location');

        $query = Job::with('employer')
            ->where('status', 'open');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($location) {
            $query->where('location', 'like', "%{$location}%");
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('public.jobs.index', compact('jobs', 'search', 'location'));
    }

    public function show(Job $job)
    {
        $job->load('employer');

        return view('public.jobs.show', compact('job'));
    }
}
