<x-app-layout>

    <x-slot:header>
        {{ __('app.edit_user') }}
    </x-slot:header>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <label>{{ __('app.firstname') }}:</label>
        <input type="text" name="firstname" value="{{ $user->firstname }}" required>

        <label>{{ __('app.lastname') }}:</label>
        <input type="text" name="lastname" value="{{ $user->lastname }}" required>

        <label>{{ __('app.email') }}:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>

        <button type="submit">{{ __('app.save') }}</button>
    </form>
</x-app-layout>