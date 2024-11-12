<x-app-layout>

    <div class="wrapper">
        <h1>
            {{ __('app.services') }}
        </h1>
        <ul>
            <li class="index-header">
                <p>{{ __('app.service_name') }}</p>
                <p>{{ __('app.costs_per_hour') }}</p>
                <p>{{ __('app.service_number') }}</p>
            </li>
            @foreach($services as $service)
                <li>
                    @can('update', $service)
                        <a class="index-link" href="{{ route('services.edit', $service->id) }}">
                            <p>{{ $service->name }}</p>
                            <p>{{ $service->costs_per_hour }} €</p>
                            <p>{{ $service->id }}</p>
                        </a>
                    @else
                        <a class="index-link" href="{{ route('services.show', $service->id) }}">
                            <p>{{ $service->name }}</p>
                            <p>{{ $service->costs_per_hour }} €</p>
                            <p>{{ $service->id }}</p>
                        </a>
                    @endcan
                </li>
            @endforeach

        </ul>

        <div class="mt-4">
            {{ $services->links() }}
        </div>

        @can('create', App\Models\Service::class)
            <div class="button-bottom-bar">
                <x-partials.action-link
                        href="{{ route('services.create') }}">{{ __('app.create_new_service') }}
                </x-partials.action-link>
            </div>
        @endcan
    </div>

</x-app-layout>