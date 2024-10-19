<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('app.app_title') }}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
<div class="wrapper">
    <x-navigation></x-navigation>

    <main>
        <div class="wrapper">
            @if (isset($header))
                <header>
                    {{ $header }}
                </header>
            @endif
            {{ $slot }}
            @livewireScripts
        </div>
    </main>

    <footer>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>

</div>
</body>
</html>
