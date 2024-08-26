<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.services') }}
            </h1>

            <x-partials.action-button
                    href="{{ route('services.create') }}">{{ __('app.create_new_service') }}
            </x-partials.action-button>
        </x-slot:header>

        <ul>
            @foreach($services as $service)
                <li>
                    <a href="{{ route('services.show', $service->id) }}">
                        {{ $service->name }}</a>
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
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