<x-app-layout>

    <x-slot:header>
        Contract lists
    </x-slot:header>

    <a href="{{ route('contracts.create') }}">Create new Contract</a>
    <ul>
        @foreach($contracts as $contract)
            <li>
                <a href="{{ route('contracts.show', $contract->id) }}" class="text-white">{{ $contract->name }}</a>
                <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>