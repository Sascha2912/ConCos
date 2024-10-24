<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.customers') }}
            </h1>
        </x-slot:header>

        <ul>
            <li class="grid grid-cols-3 place-content-between j p-1.5 bg-blue-400 text-white">
                <p class="column-entry">{{ __('app.company_name') }}</p>
                <p class="column-entry">{{ __('app.managing_director') }}</p>
                <p class="column-entry">{{ __('app.customer_number') }}</p>
            </li>
            @foreach($customers as $customer)
                <li>
                    <a class="grid grid-cols-3 place-content-between"
                       href="{{ route('customers.edit', $customer->id) }}">
                        <p class="column-entry">{{ $customer->name }}</p>
                        <p class="column-entry">{{ $customer->managing_director }}</p>
                        <p class="column-entry">{{ $customer->id }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('customers.create') }}">{{ __('app.create_new_customer') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>