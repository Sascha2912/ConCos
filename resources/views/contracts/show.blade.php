<x-app-layout>

    <x-slot:header>
        Contract ID: {{ $contract->id }}
    </x-slot:header>

    <p>Name: {{ $contract->name }}</p>
    <p>Hours: {{ $contract->hours }}</p>
    <p>Monthly costs: {{ $contract->monthly_costs }}</p>
    <p>Flatrate: {{ $contract->flatrate }}</p>
    <p>Start date: {{ $contract->start_date }}</p>
    <p>End date: {{ $contract->end_date }}</p>

    <h2>Services</h2>
    <ul>
        @foreach($contract->services as $service)
            <li>{{ $service->name }}</li>
        @endforeach
    </ul>

</x-app-layout>