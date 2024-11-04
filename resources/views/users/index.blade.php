<x-app-layout>

    <div class="wrapper">
        <h1>
            {{ __('app.users') }}
        </h1>

        <ul>
            <li class="index-header">
                <p>{{ __('app.firstname') }}</p>
                <p>{{ __('app.lastname') }}</p>
                <p>{{ __('app.role') }}</p>
            </li>
            @foreach($users as $user)
                <li>
                    <a class="index-link" href="{{ route('users.show', $user->id) }}">
                        <p>{{ $user->firstname }}</p>
                        <p>{{ $user->lastname }}</p>
                        <p>{{ $user->role }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $users->links() }}
        </div>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('users.create') }}">{{ __('app.create_new_user') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>