<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.time_logs') }}
            </h1>
        </x-slot:header>

        <ul>
            @foreach($timelogs as $timelog)
                <li>
                    <a href="{{ route('timelogs.show', $timelog->id) }}">
                        {{ __('app.customer') }}: {{ $timelog->customer->firstname }} {{ $timelog->customer->lastname }}
                        {{ __('app.service') }}: {{ $timelog->service->name }}
                        {{ __('app.hours') }}: {{ $timelog->hours }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('timelogs.create') }}">{{ __('app.create_new_time_log') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>