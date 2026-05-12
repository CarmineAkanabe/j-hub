<aside class="sticky top-16 hidden h-[calc(100vh-4rem)] w-72 shrink-0 border-r border-slate-800 bg-slate-950 px-5 py-6 text-slate-100 md:block">
    <div class="mb-8 rounded-2xl bg-slate-900/80 px-4 py-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Employer</p>
        <p class="mt-1 truncate text-base font-semibold text-white">{{ auth()->user()->name }}</p>
    </div>
    <nav class="space-y-1.5 text-sm font-medium">
        <a href="/employer/dashboard"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('employer.dashboard') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Dashboard</a>
        <a href="/employer/jobs"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('employer.jobs.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Jobs</a>
        <a href="/employer/applicants"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('employer.applicants.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Applicants</a>
        <a href="/employer/notifications"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('employer.notifications.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Notifications</a>
        <a href="/employer/profile"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('employer.profile') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Profile</a>
    </nav>
</aside>
