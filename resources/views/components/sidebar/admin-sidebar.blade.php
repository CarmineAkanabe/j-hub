<aside class="hidden w-72 shrink-0 bg-slate-950 px-6 py-8 text-slate-100 md:block">
    <div class="mb-10 text-lg font-semibold">Admin: {{ auth()->user()->name }}</div>
    <nav class="space-y-2 text-sm">
        <a href="/admin/dashboard"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Dashboard</a>
        <a href="/admin/users"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Users</a>
        <a href="/admin/logs"
            class="block rounded-xl px-4 py-3 {{ request()->routeIs('admin.logs.*') ? 'bg-slate-900' : '' }} hover:bg-slate-800">Logs</a>
    </nav>
</aside>
