<aside class="hidden w-72 shrink-0 bg-slate-950 px-6 py-8 text-slate-100 md:block">
    <div class="mb-10 text-lg font-semibold">Job Seeker: {{ auth()->user()->name }}</div>
    <nav class="space-y-2 text-sm">
        <a href="/jobseeker/dashboard"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('jobseeker.dashboard') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Dashboard</a>
        <a href="/jobseeker/applications"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('jobseeker.applications.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Applications</a>
        <a href="/jobseeker/notifications"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('jobseeker.notifications.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Notifications</a>
        <a href="/jobseeker/profile"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('jobseeker.profile') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Profile</a>
    </nav>
</aside>
