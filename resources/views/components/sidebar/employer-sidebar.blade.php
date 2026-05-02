<aside class="hidden w-72 shrink-0 bg-slate-950 px-6 py-8 text-slate-100 md:block">
    <div class="mb-10 text-lg font-semibold">Employer: {{ auth()->user()->name }}</div>
    <nav class="space-y-2 text-sm">
        <a href="/employer/dashboard"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('employer.dashboard') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Dashboard</a>
        <a href="/employer/jobs"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('employer.jobs.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Jobs</a>
        <a href="/employer/applicants"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('employer.applicants.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Applicants</a>
        <a href="/employer/notifications"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('employer.notifications.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Notifications</a>
        <a href="/employer/profile"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('employer.profile') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Profile</a>
    </nav>
</aside>
