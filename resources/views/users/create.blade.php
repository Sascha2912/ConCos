<x-app-layout>

    <x-slot:header>
        Create new User
    </x-slot:header>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <label>Firstname:</label>
        <input type="text" name="firstname" required>

        <label>Lastname:</label>
        <input type="text" name="lastname" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input id="password" class="block mt-1 w-full"
               type="password"
               name="password"
               required autocomplete="new-password"/>

        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" class="block mt-1 w-full"
               type="password"
               name="password_confirmation" required autocomplete="new-password"/>

        <button type="submit">Create User</button>
    </form>
</x-app-layout>