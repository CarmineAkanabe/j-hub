@props([
    'type' => 'info',
    'title' => null,
    'class' => '',
])

@php
    $variants = [
        'info' => 'bg-sky-50 border-sky-200 text-sky-900',
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-900',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-900',
        'error' => 'bg-rose-50 border-rose-200 text-rose-900',
    ];
    $variantClasses = $variants[$type] ?? $variants['info'];
    $alertClasses = trim("rounded-3xl border px-4 py-4 text-sm {$variantClasses} {$class}");
@endphp

<div {{ $attributes->merge(['class' => $alertClasses]) }}>
    @if ($title)
        <div class="mb-2 font-semibold">{{ $title }}</div>
    @endif
    <div>{{ $slot }}</div>
</div>
