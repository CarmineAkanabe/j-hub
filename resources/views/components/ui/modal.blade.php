@props([
    'id' => null,
    'title' => null,
    'open' => false,
    'class' => '',
])

<div id="{{ $id }}"
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4 transition-opacity duration-200 {{ $open ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }}">
    <div class="w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl {{ $class }}">
        <div class="border-b border-slate-200 px-6 py-4">
            @if ($title)
                <h2 class="text-lg font-semibold text-slate-900">{{ $title }}</h2>
            @endif
        </div>
        <div class="p-6">{{ $slot }}</div>
    </div>
</div>
