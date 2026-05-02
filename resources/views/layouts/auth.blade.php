<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Hub — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 font-body">
    @include('components.navbar.auth-navbar')

    <div class="flex min-h-screen">
        @yield('sidebar')

        <main class="flex-1 bg-slate-50 px-4 py-8 sm:px-6 lg:px-8 pt-20">
            @yield('content')
        </main>
    </div>
    {{-- @include('components.footer') --}}
</body>

</html>
