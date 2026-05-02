<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Hub — @yield('title', 'Job Portal')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/j-hub-logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col bg-slate-50 text-slate-900 font-body">
    @if (auth()->check())
        @include('components.navbar.auth-navbar')
    @else
        @include('components.navbar.public-navbar')
    @endif

    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 pt-20 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @include('components.footer')
</body>

</html>
