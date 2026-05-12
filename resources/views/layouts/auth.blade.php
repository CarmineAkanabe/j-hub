<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Hub — @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/j-hub-logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col bg-slate-50 text-slate-900 font-body">
    @include('components.navbar.auth-navbar')

    <div class="flex flex-1">
        @yield('sidebar')

        <main class="flex-1 bg-slate-50 px-4 py-8 pt-20 sm:px-6 lg:px-10">
            @yield('content')
        </main>
    </div>
    {{-- @include('components.footer') --}}
</body>

</html>
