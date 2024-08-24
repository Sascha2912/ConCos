<x-app-layout>

    <x-slot:header>
        User
    </x-slot:header>

    <p>Firstname: {{ $user->firstname }}</p>
    <p>Lastname: {{ $user->lastname }}</p>
    <p>Email: {{ $user->email }}</p>

    <a href="{{ route('users.edit', $user->id) }}">Edit user</a>

</x-app-layout>