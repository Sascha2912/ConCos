<x-app-layout>

    <x-slot:header>
        {{ __('app.create_new_user') }}
    </x-slot:header>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <label>{{ __('app.firstname') }}:</label>
        <input type="text" name="firstname" required>

        <label>{{ __('app.lastname') }}:</label>
        <input type="text" name="lastname" required>

        <label>{{ __('app.email') }}:</label>
        <input type="email" name="email" required>

        <label for="password">{{ __('app.password') }}</label>
        <input id="password" class="block mt-1 w-full"
               type="password"
               name="password"
               required autocomplete="new-password"/>

        <label for="password_confirmation">{{ __('app.password_confirmed') }}</label>
        <input id="password_confirmation" class="block mt-1 w-full"
               type="password"
               name="password_confirmation" required autocomplete="new-password"/>

        <button type="submit">{{ __('app.create_user') }}</button>
    </form>
</x-app-layout>