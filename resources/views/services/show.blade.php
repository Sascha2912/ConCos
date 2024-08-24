<x-app-layout>

    <x-slot:header>
        {{ $service->name }}
    </x-slot:header>

    <p>Description: {{ $service->description }}</p>
    <p>Costs per hour: {{ $service->cost_per_hour }}€</p>

    <a href="{{ route('services.edit', $service->id) }}">Edit Service</a>

</x-app-layout>