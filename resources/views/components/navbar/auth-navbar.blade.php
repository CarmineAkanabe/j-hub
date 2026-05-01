<header class="border-b border-slate-200 bg-white shadow-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="/" class="text-lg font-semibold text-slate-900">J-Hub</a>

        <div class="flex items-center gap-3">
            <span class="text-sm text-slate-600">Welcome back</span>
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit"
                    class="rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Logout</button>
            </form>
        </div>
    </div>
</header>
