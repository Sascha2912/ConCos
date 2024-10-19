<x-app-layout>

    <x-slot:header>
        {{ __('app.user_overview')}}
    </x-slot:header>

    <p>{{ __('app.firstname') }}: {{ $user->firstname }}</p>
    <p>{{ __('app.lastname') }}: {{ $user->lastname }}</p>
    <p>{{ __('app.email') }}: {{ $user->email }}</p>

    <a href="{{ route('users.edit', $user->id) }}">{{ __('app.edit_user') }}</a>

</x-app-layout>