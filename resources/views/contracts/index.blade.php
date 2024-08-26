<x-app-layout>
    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.contracts') }}
            </h1>

            <x-partials.action-button
                    href="{{ route('contracts.create') }}">{{ __('app.create_new_contract') }}
            </x-partials.action-button>
        </x-slot:header>

        <ul>
            @foreach($contracts as $contract)
                <li>
                    <a href="{{ route('contracts.show', $contract->id) }}">
                        {{ $contract->name }}</a>
                    <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <x-partials.action-button type="submit"
                                                  class="delete">{{ __('app.delete') }}
                        </x-partials.action-button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

</x-app-layout>