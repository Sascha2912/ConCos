<x-app-layout>

    <x-slot:header>
        {{ $service->name }}
    </x-slot:header>

    <p>{{ __('app.description') }}: {{ $service->description }}</p>
    <p>{{ __('app.costs_per_hour') }}: {{ $service->cost_per_hour }}€</p>

    <a href="{{ route('services.edit', $service->id) }}">{{ __('app.edit_service_entry') }}</a>

</x-app-layout>