<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        Gate::authorize('view', $user);

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if (Gate::denies('delete', $user)) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        Log::info("Admin deleted user account: {$user->name} ({$user->email})");

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User account deleted successfully.');
    }
}
