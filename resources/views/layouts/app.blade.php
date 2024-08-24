<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KWV-Kunden-Wartungsverträge-Verwaltung</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
        <nav>
            <a href="/">Home</a>
            <a href="/customers">Customers</a>
            <a href="/contracts">Contracts</a>
            <a href="/services">Services</a>
            <a href="/timelogs">Time logs</a>
            <a href="/users">Users</a>
        </nav>

        <div>
            <h1>{{ $header }}</h1>
        </div>
    </header>

    <main class="mt-6">
        {{ $slot }}
    </main>

    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>

</div>
</body>
</html>
