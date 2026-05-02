<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-semibold text-slate-900 mb-4">Filters</h2>
    <div class="space-y-4">
        <div>
            <label for="location" class="block text-sm font-medium text-slate-700">Location</label>
            <input id="location" name="location" value="{{ old('location', $location ?? '') }}" type="text"
                placeholder="City, region, or remote"
                class="mt-2 block w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none focus:border-primary-600 focus:ring-2 focus:ring-primary-100" />
        </div>

        <div>
            <x-ui.button type="submit" variant="primary" class="w-full">Apply Filters</x-ui.button>
        </div>
    </div>
</div>
