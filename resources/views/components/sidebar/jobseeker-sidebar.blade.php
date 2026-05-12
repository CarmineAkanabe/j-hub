<aside class="sticky top-16 hidden h-[calc(100vh-4rem)] w-72 shrink-0 border-r border-slate-800 bg-slate-950 px-5 py-6 text-slate-100 md:block">
    <div class="mb-8 rounded-2xl bg-slate-900/80 px-4 py-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Job Seeker</p>
        <p class="mt-1 truncate text-base font-semibold text-white">{{ auth()->user()->name }}</p>
    </div>
    <nav class="space-y-1.5 text-sm font-medium">
        <a href="/jobseeker/dashboard"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('jobseeker.dashboard') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Dashboard</a>
        <a href="/jobseeker/applications"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('jobseeker.applications.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Applications</a>
        <a href="/jobseeker/comments"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('jobseeker.comments.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Comments</a>
        <a href="/jobseeker/notifications"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('jobseeker.notifications.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Notifications</a>
        <a href="/jobseeker/profile"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('jobseeker.profile') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Profile</a>
    </nav>
</aside>
