<x-app-layout>
    <div class="wrapper">
        <h1>
            {{ __('app.contracts') }}
        </h1>
        <ul>
            <li class="index-header">
                <p>{{ __('app.contract_name') }}</p>
                <p>{{ __('app.monthly_price') }}</p>
                <p>{{ __('app.contract_number') }}</p>
            </li>
            @foreach($contracts as $contract)
                <li>
                    <a class="index-link" href="{{ route('contracts.edit', $contract->id) }}">
                        <p>{{ $contract->name }}</p>
                        <p>{{ $contract->monthly_costs }} €</p>
                        <p>{{ $contract->id }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('contracts.create') }}">{{ __('app.create_new_contract') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>