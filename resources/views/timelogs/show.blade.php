<x-app-layout>

    <x-slot:header>
        Time log
    </x-slot:header>

    <p>Customer: {{ $timelog->customer->name }}</p>
    <p>Service: {{ $timelog->service->name }}</p>
    <p>Hours: {{ $timelog->hours }}</p>
    <p>Date: {{ $timelog->date }}</p>

    <a href="{{ route('timelogs.edit', $timelog->id) }}">Edit Time log</a>

</x-app-layout>