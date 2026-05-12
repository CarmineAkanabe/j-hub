<aside class="sticky top-16 hidden h-[calc(100vh-4rem)] w-72 shrink-0 border-r border-slate-800 bg-slate-950 px-5 py-6 text-slate-100 md:block">
    <div class="mb-8 rounded-2xl bg-slate-900/80 px-4 py-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Admin</p>
        <p class="mt-1 truncate text-base font-semibold text-white">{{ auth()->user()->name }}</p>
    </div>
    <nav class="space-y-1.5 text-sm font-medium">
        <a href="/admin/dashboard"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Dashboard</a>
        <a href="/admin/users"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Users</a>
        <a href="/admin/logs"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('admin.logs.*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Logs</a>
        <a href="/admin/profile"
            class="block rounded-xl px-4 py-3 transition {{ request()->routeIs('admin.profile*') ? 'bg-slate-800 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">Profile</a>
    </nav>
</aside>
