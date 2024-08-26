<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.time_logs') }}
            </h1>

            <x-partials.action-button
                    href="{{ route('timelogs.create') }}">{{ __('app.create_new_time_log') }}
            </x-partials.action-button>
        </x-slot:header>

        <ul>
            @foreach($timelogs as $timelog)
                <li>
                    <a href="{{ route('timelogs.show', $timelog->id) }}">
                        {{ __('app.customer') }}: {{ $timelog->customer->firstname }} {{ $timelog->customer->lastname }}
                        {{ __('app.service') }}: {{ $timelog->service->name }}
                        {{ __('app.hours') }}: {{ $timelog->hours }}
                    </a>
                    <form action="{{ route('timelogs.destroy', $timelog->id) }}" method="POST" style="display: inline;">
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