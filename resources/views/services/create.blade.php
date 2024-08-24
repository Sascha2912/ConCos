<x-app-layout>

    <x-slot:header>
        Create new Service
    </x-slot:header>

    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <label>Costs per hour:</label>
        <input type="number" name="cost_per_hour" step="0.01" required>

        <button type="submit">Create service</button>
    </form>
</x-app-layout>