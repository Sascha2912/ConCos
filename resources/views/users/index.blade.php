<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.users') }}
            </h1>

            <x-partials.action-button
                    href="{{ route('users.create') }}">{{ __('app.create_new_user') }}
            </x-partials.action-button>
        </x-slot:header>

        <ul>
            @foreach($users as $user)
                <li>
                    <a href="{{ route('users.show', $user->id) }}">
                        {{ $user->firstname }} {{ $user->lastname }}</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
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