<x-app-layout>

    <x-slot:header>
        Overview for {{ $customer->firstname }}  {{ $customer->lastname }}
    </x-slot:header>

    <p><strong>Contractually agreed hours:</strong> {{ $contractHours }}</p>
    <p><strong>Hours used so far:</strong> {{ $usedHours }}</p>
    <p><strong>Monthly costs:</strong> €{{ $monthlyCosts }}</p>
    <p><strong>Extra costs:</strong> €{{ $extraCosts }}</p>

    <h2>Details of time recording</h2>
    <ul>
        @foreach($customer->timelogs as $timelog)
            <li>
                Service: {{ $timelog->service->name }},
                Hours: {{ $timelog->hours }},
                Data: {{ $timelog->date }},
                Costs: €{{ $timelog->service->cost_per_hour * $timelog->hours }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('customers.edit', $customer->id) }}">Edit Customer</a>
    <a href="{{ route('invoice.create', $customer->id) }}">Print</a>

</x-app-layout>