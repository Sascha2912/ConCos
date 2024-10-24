<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.login') }}</title>
    @vite(['resources/scss/app.scss'])
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xl bg-white shadow-md rounded-lg p-6 flex items-center justify-center">
        {{ $slot }}
    </div>
</div>

</body>
</html>