<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.customers') }}
            </h1>

            <x-partials.action-button
                    href="{{ route('customers.create') }}">{{ __('app.create_new_customer') }}
            </x-partials.action-button>
        </x-slot:header>

        <ul>
            @foreach($customers as $customer)
                <li>
                    <a href="{{ route('customers.show', $customer->id) }}">
                        {{ $customer->firstname }} {{ $customer->lastname }}</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
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