@php
    $month = now()->month;
    $year = now()->year;
@endphp

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

        <livewire:customers.monthly-report :customerId="$customer->id" :month="$month" :year="$year"/>
    </div>

</x-app-layout>