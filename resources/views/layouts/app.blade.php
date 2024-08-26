<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KWV-Kunden-Wartungsverträge-Verwaltung</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
<div>

    <header>
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

    <main>
        {{ $slot }}
    </main>

    <footer>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>

</div>
</body>
</html>
