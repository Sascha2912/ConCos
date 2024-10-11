<x-app-layout>

    <x-slot:header>
        {{ __('app.contract') }} ID: {{ $contract->id }}
    </x-slot:header>

    <p>{{ __('app.name') }}: {{ $contract->name }}</p>
    <p>{{ __('app.hours') }}: {{ $contract->hours }}</p>
    <p>{{ __('app.monthly_costs') }}: {{ $contract->monthly_costs }}</p>
    <p>{{ __('app.flatrate') }}: {{ $contract->flatrate }}</p>
    <p>{{ __('app.start_date') }}: {{ $contract->start_date }}</p>
    <p>{{ __('app.end_date') }}: {{ $contract->end_date }}</p>

    <h2>{{ __('app.services') }}</h2>
    <ul>
        @foreach($contract->services as $service)
            <li>{{ $service->name }}</li>
        @endforeach
    </ul>

    <a href="{{ route('contracts.edit', $contract->id) }}">{{ __('app.edit_contract') }}</a>

</x-app-layout>