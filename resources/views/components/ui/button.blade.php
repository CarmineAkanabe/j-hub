@props([
    'variant' => 'primary',
    'type' => 'button',
    'disabled' => false,
    'class' => '',
    'size' => 'md',
])

@php
    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 focus-visible:ring-slate-500',
        'secondary' => 'bg-white border border-slate-300 text-slate-900 hover:bg-slate-50 focus-visible:ring-slate-500',
        'ghost' => 'bg-transparent text-slate-900 hover:bg-slate-100 focus-visible:ring-slate-500',
        'outline' => 'border border-slate-300 bg-white text-slate-900 hover:bg-slate-50 focus-visible:ring-slate-500',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 focus-visible:ring-rose-500',
    ];
    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-3 text-base',
    ];
    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $buttonClasses = trim(
        "inline-flex items-center justify-center rounded-full font-medium transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 {$variantClasses} {$sizeClasses} {$class}",
    );
    $href = $attributes->get('href');
    $buttonAttributes = $href ? $attributes->except('href') : $attributes;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $buttonAttributes->merge(['class' => $buttonClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }}
        {{ $buttonAttributes->merge(['class' => $buttonClasses]) }}>
        {{ $slot }}
    </button>
@endif
