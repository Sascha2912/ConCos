<x-app-layout>
    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.contracts') }}
            </h1>
        </x-slot:header>

        <ul>
            <li class="grid grid-cols-3 place-content-between j p-1.5 bg-blue-400 text-white">
                <p class="column-entry">{{ __('app.contract_name') }}</p>
                <p class="column-entry">{{ __('app.monthly_price') }}</p>
                <p class="column-entry">{{ __('app.contract_number') }}</p>
            </li>
            @foreach($contracts as $contract)
                <li>
                    <a class="grid grid-cols-3 place-content-between"
                       href="{{ route('contracts.edit', $contract->id) }}">
                        <p class="column-entry">{{ $contract->name }}</p>
                        <p class="column-entry">{{ $contract->monthly_costs }} €</p>
                        <p class="column-entry">{{ $contract->id }}</p>
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