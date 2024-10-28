<x-app-layout>

    <x-slot:header>
        {{ __('app.invoice_for') }} {{ $customer->firstname }} {{ $customer->firstname }}
    </x-slot:header>

    <p><strong>{{ __('app.contractually_agreed_hours') }}:</strong> {{ $contractHours }}</p>
    <p><strong>{{ __('app.hours_used_so_far') }}:</strong> {{ $usedHours }}</p>
    <p><strong>{{ __('app.monthly_costs') }}:</strong> €{{ $monthlyCosts }}</p>
    <p><strong>{{ __('app.extra_costs') }}:</strong> €{{ $extraCosts }}</p>
    <p><strong>{{ __('app.total_costs') }}:</strong> €{{ $total }}</p>

    <button onclick="window.print()">{{ __('app.print') }}</button>
</x-app-layout>