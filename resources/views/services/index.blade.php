<x-app-layout>

    <x-slot:header>
        Service lists
    </x-slot:header>

    <a href="{{ route('services.create') }}">Create new Service</a>
    <ul>
        @foreach($services as $service)
            <li>
                <a href="{{ route('services.show', $service->id) }}" class="text-white">{{ $service->name }}</a>
                <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>