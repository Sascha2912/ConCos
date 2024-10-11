<x-app-layout>

    <x-slot:header>
        {{ __('app.time_log') }}
    </x-slot:header>

    <p>{{ __('app.customer') }}: {{ $timelog->customer->name }}</p>
    <p>{{ __('app.service') }}: {{ $timelog->service->name }}</p>
    <p>{{ __('app.hours') }}: {{ $timelog->hours }}</p>
    <p>{{ __('app.date') }}: {{ $timelog->date }}</p>

    <a href="{{ route('timelogs.edit', $timelog->id) }}">{{ __('app.edit_time_entry') }}</a>

</x-app-layout>