<x-app-layout>

    <x-slot:header>
        Edit Service
    </x-slot:header>

    <form method="POST" action="{{ route('services.update', $service->id) }}">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $service->name }}" required>

        <label>Description:</label>
        <textarea name="description">{{ $service->description }}</textarea>

        <label>Costs per hour:</label>
        <input type="number" name="cost_per_hour" step="0.01" value="{{ $service->cost_per_hour }}" required>

        <button type="submit">Save</button>
    </form>
</x-app-layout>