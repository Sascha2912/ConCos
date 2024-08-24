<x-app-layout>

    <x-slot:header>
        Edit User
    </x-slot:header>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <label>Firstname:</label>
        <input type="text" name="firstname" value="{{ $user->firstname }}" required>

        <label>Lastname:</label>
        <input type="text" name="lastname" value="{{ $user->lastname }}" required>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>

        <button type="submit">Save</button>
    </form>
</x-app-layout>