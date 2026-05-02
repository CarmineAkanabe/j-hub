<header class="fixed top-0 w-full bg-slate-950 shadow-sm z-50">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="/" class="text-lg font-semibold text-white">J-Hub</a>

        <nav class="hidden gap-6 text-sm text-slate-300 md:flex">
            <a href="{{ route('jobs.index') }}" class="hover:text-white">Jobs</a>
            <a href="/about" class="hover:text-white">About</a>
            @if (auth()->user()->isEmployer())
                <a href="{{ route('employer.dashboard') }}" class="hover:text-white">Account</a>
            @elseif(auth()->user()->isJobSeeker())
                <a href="{{ route('jobseeker.dashboard') }}" class="hover:text-white">Account</a>
            @elseif(auth()->user()->isAdmin())
                <a href="/admin/dashboard" class="hover:text-white">Dashboard</a>
            @endif
        </nav>

        <div class="flex items-center gap-3">
            <span class="text-sm text-slate-300">Welcome back, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <x-ui.button type="submit" class="bg-red-800 hover:bg-red-900 text-white">
                    Logout
                </x-ui.button>
            </form>
        </div>
    </div>
</header>
