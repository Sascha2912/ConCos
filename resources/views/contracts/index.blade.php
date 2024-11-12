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
                    @can('update', $contract)
                        <a class="index-link" href="{{ route('contracts.edit', $contract->id) }}">
                            <p>{{ $contract->name }}</p>
                            <p>{{ $contract->monthly_costs }} €</p>
                            <p>{{ $contract->id }}</p>
                        </a>
                    @else
                        <a class="index-link" href="{{ route('contracts.show', $contract->id) }}">
                            <p>{{ $contract->name }}</p>
                            <p>{{ $contract->monthly_costs }} €</p>
                            <p>{{ $contract->id }}</p>
                        </a>
                    @endcan
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $contracts->links() }}
        </div>

        @can('create', App\Models\Contract::class)
            <div class="button-bottom-bar">
                <x-partials.action-link
                        href="{{ route('contracts.create') }}">{{ __('app.create_new_contract') }}
                </x-partials.action-link>
            </div>
        @endcan
    </div>

</x-app-layout>