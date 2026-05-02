<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jobSeeker = auth()->user();
        $applicationCount = $jobSeeker->applications()->count();

        return view('jobseeker.dashboard', compact('applicationCount'));
    }
}
