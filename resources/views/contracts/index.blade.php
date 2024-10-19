<x-app-layout>
    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.contracts') }}
            </h1>
        </x-slot:header>

        <ul>
            <li class="flex gap-10 p-1.5 bg-blue-400 text-white">
                <p class="column-entry">{{ __('app.contract_name') }}</p>
                <p class="column-entry">{{ __('app.monthly_costs') }}</p>
                <p class="column-entry">{{ __('app.start_date') }}</p>
                <p class="column-entry">{{ __('app.end_date') }}</p>
                <p class="column-entry">{{ __('app.contract_number') }}</p>
            </li>
            @foreach($contracts as $contract)
                <li>
                    <a href="{{ route('contracts.show', $contract->id) }}">
                        <p class="column-entry">{{ $contract->name }}</p>
                        <p class="column-entry">{{ $contract->monthly_costs }}</p>
                        <p class="column-entry">{{ $contract->start_date }}</p>
                        <p class="column-entry">{{ $contract->end_date }}</p>
                        <p class="column-entry">{{ $contract->id }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="button-bar">
            <x-partials.action-link
                    href="{{ route('contracts.create') }}">{{ __('app.create_new_contract') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>