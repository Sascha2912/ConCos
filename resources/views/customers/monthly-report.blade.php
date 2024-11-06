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
                                 :active="request()->is('customers.timelogs')">
                {{ __('app.time_logs') }}
            </x-partials.nav-link>

            @can('update', $customer)
                <x-partials.nav-link
                        href="{{ route('customers.edit', $customer->id) }}"
                        :active="request()->routeIs('customers.edit')"
                >
                    {{ __('app.edit_customer') }}
                </x-partials.nav-link>
            @else
                <x-partials.nav-link
                        href="{{ route('customers.show', $customer->id) }}"
                        :active="request()->routeIs('customers.show')"
                >
                    {{ __('app.customer_data') }}
                </x-partials.nav-link>
            @endcan
        </nav>

        <livewire:customers.monthly-report :customerId="$customer->id"/>
    </div>

</x-app-layout>