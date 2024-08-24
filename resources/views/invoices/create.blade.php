<x-app-layout>

    <x-slot:header>
        Invoice for {{ $customer->firstname }} {{ $customer->firstname }}
    </x-slot:header>

    <p><strong>Contractually agreed hours:</strong> {{ $contractHours }}</p>
    <p><strong>Hours used so far:</strong> {{ $usedHours }}</p>
    <p><strong>Monthly costs:</strong> €{{ $monthlyCosts }}</p>
    <p><strong>Extra costs:</strong> €{{ $extraCosts }}</p>
    <p><strong>Total costs:</strong> €{{ $total }}</p>

    <button onclick="window.print()">Print invoice</button>
</x-app-layout>