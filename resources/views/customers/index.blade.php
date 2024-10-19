<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.customers') }}
            </h1>
        </x-slot:header>

        <ul>
            <li class="flex gap-10 p-1.5 bg-blue-400 text-white">
                <p class="column-entry">{{ __('app.firstname') }}</p>
                <p class="column-entry">{{ __('app.lastname') }}</p>
                <p class="column-entry">{{ __('app.customer_number') }}</p>
            </li>
            @foreach($customers as $customer)
                <li>
                    <a href="{{ route('customers.edit', $customer->id) }}">
                        <p class="column-entry">{{ $customer->firstname }}</p>
                        <p class="column-entry">{{ $customer->lastname }}</p>
                        <p class="column-entry">{{ $customer->id }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="button-bar">
            <x-partials.action-link
                    href="{{ route('customers.create') }}">{{ __('app.create_new_customer') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>