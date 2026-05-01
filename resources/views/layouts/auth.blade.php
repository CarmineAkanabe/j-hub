<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J-Hub — @yield('title', 'Dashboard')</title>
    {{-- TODO: add vite css/js --}}
</head>
<body>
    {{-- TODO: auth navbar component --}}

    <div class="flex">
        @yield('sidebar') {{-- role-specific sidebar injected per view --}}

        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    {{-- TODO: footer component --}}
</body>
</html>
