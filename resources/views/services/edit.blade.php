<x-app-layout>

    <x-slot:header>
        {{ __('app.edit_service_entry') }}
    </x-slot:header>

    <form method="POST" action="{{ route('services.update', $service->id) }}">
        @csrf
        @method('PUT')

        <label>{{ __('app.service') }}:</label>
        <input type="text" name="name" value="{{ $service->name }}" required>

        <label>{{ __('app.description') }}:</label>
        <textarea name="description">{{ $service->description }}</textarea>

        <label>{{ __('app.costs_per_hour') }}:</label>
        <input type="number" name="cost_per_hour" step="0.01" value="{{ $service->cost_per_hour }}" required>

        <button type="submit">{{ __('app.save') }}</button>
    </form>
</x-app-layout>