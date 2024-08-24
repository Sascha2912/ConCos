<x-app-layout>

    <x-slot:header>
        User lists
    </x-slot:header>

    <a href="{{ route('users.create') }}">Create new users</a>
    <ul>
        @foreach($users as $user)
            <li>
                <a href="{{ route('users.show', $user->id) }}"
                   class="text-white">{{ $user->firstname }} {{ $user->lastname }}</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>