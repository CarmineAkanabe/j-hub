@props(['job'])

@php
    $companyName = $job->employer->company_name ?? ($job->employer->name ?? 'Company Name');
    $statusLabel = optional($job->status)->value ?? $job->status;
@endphp

<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="text-lg font-semibold text-slate-900 mb-1">
                <a href="{{ route('jobs.show', $job) }}"
                    class="hover:text-primary-600 transition-colors">{{ $job->title }}</a>
            </h3>
            <p class="text-sm text-slate-600">{{ $companyName }}</p>
        </div>
        <x-ui.badge variant="success" class="text-xs">{{ ucfirst($statusLabel) }}</x-ui.badge>
    </div>

    <p class="text-slate-700 text-sm mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit($job->description, 150) }}</p>

    <div class="flex items-center text-sm text-slate-500 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
            </path>
        </svg>
        {{ $job->location }}
    </div>

    @if ($job->expected_salary)
        <div class="flex items-center text-sm text-slate-500 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                </path>
            </svg>
            ${{ number_format($job->expected_salary) }}
        </div>
    @endif

    <div class="flex justify-between items-center">
        <span class="text-xs text-slate-400">{{ $job->created_at->diffForHumans() }}</span>
        <a href="{{ route('jobs.show', $job) }}"
            class="inline-flex items-center rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-primary-700">
            View Details
        </a>
    </div>
</div>
