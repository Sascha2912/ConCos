<x-app-layout>

    <div class="wrapper">
        <h1>
            {{ __('app.customers') }}
        </h1>
        <ul>
            <li class="index-header">
                <p>{{ __('app.company_name') }}</p>
                <p>{{ __('app.managing_director') }}</p>
                <p>{{ __('app.customer_number') }}</p>
            </li>
            @foreach($customers as $customer)
                <li>
                    <a class="index-link" href="{{ route('monthly.report.show', $customer->id) }}">
                        <p>{{ $customer->name }}</p>
                        <p>{{ $customer->managing_director }}</p>
                        <p>{{ $customer->id }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $customers->links() }}
        </div>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('customers.create') }}">{{ __('app.create_new_customer') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>