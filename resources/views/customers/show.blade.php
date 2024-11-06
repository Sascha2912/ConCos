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
        <form>
            @csrf

            <!-- Form Input Fields -->
            <x-forms.input-field
                    name="name"
                    label="{{ __('app.company_name') }}"
                    type="text"
                    :required="true"
                    value="{{ $customer->name }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="managing_director"
                    label="{{ __('app.managing_director') }}"
                    type="text"
                    :required="true"
                    value="{{ $customer->managing_director }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="phone"
                    label="{{ __('app.phone') }}"
                    type="text"
                    value="{{ $customer->phone }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="email"
                    label="{{ __('app.email') }}"
                    type="text"
                    :required="true"
                    value="{{ $customer->email }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="street"
                    label="{{ __('app.street') }}"
                    type="text"
                    value="{{ $customer->street }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="house_number"
                    label="{{ __('app.house_number') }}"
                    type="text"
                    value="{{ $customer->house_number }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="city"
                    label="{{ __('app.city') }}"
                    type="text"
                    value="{{ $customer->city }}"
                    :disabled="true"/>

            <x-forms.input-field
                    name="zip_code"
                    label="{{ __('app.zip_code') }}"
                    type="text"
                    value="{{ $customer->zip_code }}"
                    :disabled="true"/>
        </form>

        <div>
            <!-- Selected Contracts -->
            <h2 class="item-heading">{{ __('app.current_contracts') }}:</h2>
            <ul class="item-wrapper">
                @foreach($contracts as $contract)
                    <li>
                        <!-- Contract Information -->

                        <div class="item">
                            <span class="item-text">{{ $contract['name'] }}</span>
                        </div>
                        <div class="item-edit">

                            <x-forms.input-field
                                    name="start_date"
                                    id="start_date_{{ $contract['id'] }}"
                                    label="{{ __('app.start_date') }}"
                                    type="date"
                                    :required="true"
                                    value="{{ $contract->pivot->start_date }}"
                                    :disabled="true"/>

                            <x-forms.input-field
                                    name="end_date"
                                    id="end_date_{{ $contract['id'] }}"
                                    label="{{ __('app.end_date') }}"
                                    type="date"
                                    value="{{ $contract->pivot->end_date }}"
                                    :disabled="true"/>
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Button-Bottom-Bar -->
        <div class="button-bottom-bar">
            <x-partials.action-link href="/customers"
                                    class="back ">{{ __('app.back') }}</x-partials.action-link>
        </div>
    </div>

</x-app-layout>