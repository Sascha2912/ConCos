<x-app-layout>

    <x-slot:header>
        {{ __('app.overview_for') }} {{ $customer->firstname }}  {{ $customer->lastname }}
    </x-slot:header>

    <p><strong>{{ __('app.contractually_agreed_hours') }}:</strong> {{ $contractHours }}</p>
    <p><strong>{{ __('app.hours_used_so_far') }}:</strong> {{ $usedHours }}</p>
    <p><strong>{{ __('app.monthly_costs') }}:</strong> €{{ $monthlyCosts }}</p>
    <p><strong>{{ __('app.extra_costs') }}:</strong> €{{ $extraCosts }}</p>

    <h2>{{ __('app.details_of_time_recording') }}</h2>
    <ul>
        @foreach($customer->timelogs as $timelog)
            <li>
                {{ __('app.service') }}: {{ $timelog->service->name }},
                {{ __('app.hours') }}: {{ $timelog->hours }},
                {{ __('app.date') }}: {{ $timelog->date }},
                {{ __('app.costs') }}: €{{ $timelog->service->cost_per_hour * $timelog->hours }}
            </li>
        @endforeach
    </ul>

    <x-partials.nav-link
            href="/timelogs"
            :active="request()->is('timelogs')"
    >
        {{ __('app.time_logs') }}
    </x-partials.nav-link>
    <a href="{{ route('customers.edit', $customer->id) }}">{{ __('app.edit_customer') }}</a>
    <a href="{{ route('invoice.create', $customer->id) }}">{{ __('app.print') }}</a>

</x-app-layout>