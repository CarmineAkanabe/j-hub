@props(['status' => 'pending'])

@php
$statusValue = $status instanceof \App\Enums\ApplicationStatus ? $status->value : $status;
$statusValue = is_string($statusValue) && array_key_exists($statusValue, [
    'pending' => true,
    'accepted' => true,
    'refused' => true,
]) ? $statusValue : 'pending';

$variants = [
    'pending' => 'bg-amber-100 text-amber-800',
    'accepted' => 'bg-emerald-100 text-emerald-800',
    'refused' => 'bg-rose-100 text-rose-800',
];
$label = ucfirst($statusValue);
$badgeClasses = trim("inline-flex rounded-full px-3 py-1 text-xs font-semibold {$variants[$statusValue]}");
@endphp

<span {{ $attributes->merge(['class' => $badgeClasses]) }}>{{ $label }}</span>
