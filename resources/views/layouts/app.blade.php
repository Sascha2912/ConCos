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

<x-navigation/>

<main>
    <x-message-box/>
    {{ $slot }}
    @livewireScripts
</main>

<footer>
    Abschlussprojekt (KWV), von Sascha Holzigel, 2024, umgesetzt mit Laravel
    v{{ Illuminate\Foundation\Application::VERSION }} (PHP
    v{{ PHP_VERSION }})
</footer>

</body>
</html>
