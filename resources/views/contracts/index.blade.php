<x-app-layout>

    <x-slot:header>
        Contract lists
    </x-slot:header>

    <a href="{{ route('contracts.create') }}">Create new Contract</a>
    <ul>
        @foreach($contracts as $contract)
            <li>
                <a href="{{ route('contracts.show', $contract->id) }}" class="text-white">{{ $contract->name }}</a>
            </li>
        @endforeach
    </ul>
</x-app-layout>