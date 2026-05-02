<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterEmployerRequest;
use App\Http\Requests\Auth\RegisterJobSeekerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showJobSeekerForm()
    {
        return view('auth.register.jobseeker');
    }

    public function showEmployerForm()
    {
        return view('auth.register.employer');
    }

    public function registerJobSeeker(RegisterJobSeekerRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => UserRole::JOBSEEKER->value,
            'resume' => $request->resume,
        ]);

        Auth::login($user);

        return redirect('/jobseeker/dashboard');
    }

    public function registerEmployer(RegisterEmployerRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => UserRole::EMPLOYER->value,
            'company_name' => $request->company_name,
        ]);

        Auth::login($user);

        return redirect('/employer/dashboard');
    }
}
