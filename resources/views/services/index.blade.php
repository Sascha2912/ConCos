<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.services') }}
            </h1>
        </x-slot:header>

        <ul>
            <li class="grid grid-cols-3 place-content-between j p-1.5 bg-blue-400 text-white">
                <p class="column-entry">{{ __('app.service_name') }}</p>
                <p class="column-entry">{{ __('app.costs_per_hour') }}</p>
                <p class="column-entry">{{ __('app.service_number') }}</p>
            </li>
            @foreach($services as $service)
                <li>
                    <a class="grid grid-cols-3 place-content-between" href="{{ route('services.show', $service->id) }}">
                        <p class="column-entry">{{ $service->name }}</p>
                        <p class="column-entry">{{ $service->costs_per_hour }} €</p>
                        <p class="column-entry">{{ $service->id }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('services.create') }}">{{ __('app.create_new_service') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>