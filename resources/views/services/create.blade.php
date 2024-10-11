<x-app-layout>

    <x-slot:header>
        {{ __('app.create_new_service') }}
    </x-slot:header>

    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <label>{{ __('app.name') }}:</label>
        <input type="text" name="name" required>

        <label>{{ __('app.description') }}:</label>
        <textarea name="description"></textarea>

        <label>{{ __('app.cost_per_hour') }}:</label>
        <input type="number" name="cost_per_hour" step="0.01" required>

        <button type="submit">{{ __('app.create_service') }}</button>
    </form>
</x-app-layout>