<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Hub — @yield('title', 'Job Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 font-body">
    @if (auth()->check())
        @include('components.navbar.auth-navbar')
    @else
        @include('components.navbar.public-navbar')
    @endif

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @include('components.footer')
</body>

</html>
