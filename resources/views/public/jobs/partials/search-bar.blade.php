<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Search Jobs</h2>
    <div class="space-y-4">
        <div>
            <label for="search" class="block text-sm font-medium text-slate-700">Keyword</label>
            <input id="search" name="search" value="{{ old('search', $search ?? '') }}" type="text"
                placeholder="Search roles, skills, or companies"
                class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-100" />
        </div>
    </div>
</div>
