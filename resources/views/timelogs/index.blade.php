<x-app-layout>
    <div class="wrapper">
        <h1>{{ __('app.customer_section') }}</h1>
        <nav class="customer-nav">
            <x-partials.nav-link
                    href="{{ route('monthly.report.show', $customer->id) }}"
                    :active="request()->routeIs('monthly.report.show')"
            >
                {{ __('app.customer_overview') }}
            </x-partials.nav-link>

            <x-partials.nav-link href="{{ route('customers.timelogs.index', $customer->id) }}"
                                 :active="request()->routeIs('customers.timelogs.index')">
                {{ __('app.time_logs') }}
            </x-partials.nav-link>

            <x-partials.nav-link
                    href="{{ route('customers.show', $customer->id) }}"
                    :active="request()->routeIs('customers.show')"
            >
                {{ __('app.customer_data') }}
            </x-partials.nav-link>

            <x-partials.nav-link
                    href="{{ route('customers.edit', $customer->id) }}"
                    :active="request()->routeIs('customers.edit')"
            >
                {{ __('app.edit_customer') }}
            </x-partials.nav-link>

        </nav>

        <ul>
            <li class="index-header-4">
                <p>{{ __('app.name') }}</p>
                <p>{{ __('app.service') }}</p>
                <p>{{ __('app.hours') }}</p>
                <p>{{ __('app.date') }}</p>
            </li>
            @foreach($timelogs as $timelog)
                <li>
                    <a class="index-link-4"
                       href="{{ route('timelogs.edit', $timelog->id) }}">
                        <p>{{ $timelog->customer->name }}</p>
                        <p>{{ $timelog->service->name }}</p>
                        <p>{{ $timelog->hours }}</p>
                        <p>{{ $timelog->date }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('customers.timelogs.create', $customer->id) }}">{{ __('app.create_new_time_log') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>