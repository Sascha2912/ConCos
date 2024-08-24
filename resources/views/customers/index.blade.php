<x-app-layout>

    <x-slot:header>
       Customer lists
    </x-slot:header>

    <a href="{{ route('customers.create') }}">Create new Customers</a>
    <ul>
        @foreach($customers as $customer)
            <li>
                <a href="{{ route('customers.show', $customer->id) }}" class="text-white">{{ $customer->firstname }} {{ $customer->lastname }}</a>
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>