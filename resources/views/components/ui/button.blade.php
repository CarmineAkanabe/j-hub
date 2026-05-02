@props([
    'variant' => 'primary',
    'type' => 'button',
    'disabled' => false,
    'class' => '',
])

@php
    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 focus-visible:ring-slate-500',
        'secondary' => 'bg-white border border-slate-300 text-slate-900 hover:bg-slate-50 focus-visible:ring-slate-500',
        'ghost' => 'bg-transparent text-slate-900 hover:bg-slate-100 focus-visible:ring-slate-500',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 focus-visible:ring-rose-500',
    ];
    $baseClasses =
        'inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2';
    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $buttonClasses = trim("{$baseClasses} {$variantClasses} {$class}");
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $buttonClasses]) }}>
    {{ $slot }}
</button>
