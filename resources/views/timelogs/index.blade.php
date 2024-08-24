<x-app-layout>

    <x-slot:header>
        Time logs
    </x-slot:header>

    <a href="{{ route('timelogs.create') }}">Create new Time log</a>
    <ul>
        @foreach($timelogs as $timelog)
            <li>
                <a href="{{ route('timelogs.show', $timelog->id) }}" class="text-white">
                    Customer: {{ $timelog->customer->firstname }} {{ $timelog->customer->lastname }}
                    Service: {{ $timelog->service->name }}
                    Hours: {{ $timelog->hours }}
                </a>
                <form action="{{ route('timelogs.destroy', $timelog->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>