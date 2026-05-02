<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('jobseeker.profile.edit');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->fill($request->only(['name', 'email', 'resume']));

        if ($request->filled('password')) {
            $user->password = $request->input('password');
        }

        $user->save();

        return back()->with('success', 'Your profile has been updated.');
    }
}
