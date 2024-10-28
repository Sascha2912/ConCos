<x-app-layout>

    <div class="wrapper">
        <h1>{{ __('app.customer_section') }}</h1>
        <nav class="customer-nav">
            <x-partials.nav-link
                    href="{{ route('customers.show', $customer->id) }}"
                    :active="request()->routeIs('customers.show')"
            >
                {{ __('app.customer_overview') }}
            </x-partials.nav-link>

            <x-partials.nav-link href="{{ route('timelogs.index', $customer->id) }}"
                                 :active="request()->is('timelogs')">
                {{ __('app.time_logs') }}
            </x-partials.nav-link>

            <x-partials.nav-link
                    href="{{ route('customers.edit', $customer->id) }}"
                    :active="request()->routeIs('customers.edit')"
            >
                {{ __('app.edit_customer') }}
            </x-partials.nav-link>

        </nav>
        <div class="info-box">
            <p><strong>{{ __('app.contractually_agreed_hours') }}:</strong> {{ $contractHours }}</p>
            <p><strong>{{ __('app.hours_used_so_far') }}:</strong> {{ $usedHours }}</p>
            <p><strong>{{ __('app.monthly_costs') }}:</strong> €{{ number_format($monthlyCosts, 2) }}</p>
            <p><strong>{{ __('app.extra_costs') }}:</strong> €{{ number_format($extraCosts, 2) }}</p>
        </div>

        <h2>{{ __('app.details_of_time_recording') }}</h2>
        <ul>
            @foreach($customer->timelogs as $timelog)
                <li>
                    {{ __('app.service') }}: {{ $timelog->service->name }},
                    {{ __('app.hours') }}: {{ $timelog->hours }},
                    {{ __('app.date') }}: {{ $timelog->date }},
                    {{ __('app.costs') }}:
                                           €{{ number_format(optional($timelog->service)->cost_per_hour * ($timelog->hours ?? 0), 2) }}
                </li>
            @endforeach
        </ul>

        <!-- Button-Bottom-Bar -->
        <div class="button-bottom-bar">
            <x-partials.action-link href="/customers" class="back">{{ __('app.back') }}</x-partials.action-link>
            <x-partials.action-link
                    href="{{ route('invoice.create', $customer->id) }}">{{ __('app.monthly_report') }}</x-partials.action-link>
        </div>
    </div>

</x-app-layout>