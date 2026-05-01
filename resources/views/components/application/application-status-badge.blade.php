@props(['status' => 'pending'])

@php
$variants = [
    'pending' => 'bg-amber-100 text-amber-800',
    'accepted' => 'bg-emerald-100 text-emerald-800',
    'refused' => 'bg-rose-100 text-rose-800',
];
$label = ucfirst($status);
$badgeClasses = trim("inline-flex rounded-full px-3 py-1 text-xs font-semibold {$variants[$status] ?? $variants['pending']}");
@endphp

<span {{ $attributes->merge(['class' => $badgeClasses]) }}>{{ $label }}</span>
