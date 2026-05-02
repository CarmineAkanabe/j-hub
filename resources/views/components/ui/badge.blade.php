@props([
    'variant' => 'default',
    'class' => '',
])

@php
    $variants = [
        'default' => 'bg-slate-100 text-slate-800',
        'success' => 'bg-emerald-100 text-emerald-800',
        'error' => 'bg-rose-100 text-rose-800',
        'warning' => 'bg-amber-100 text-amber-800',
        'info' => 'bg-sky-100 text-sky-800',
    ];
    $variantClasses = $variants[$variant] ?? $variants['default'];
    $badgeClasses = trim(
        "inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {$variantClasses} {$class}",
    );
@endphp

<span {{ $attributes->merge(['class' => $badgeClasses]) }}>{{ $slot }}</span>
