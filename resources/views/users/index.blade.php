<x-app-layout>

    <div class="index-wrapper">
        <x-slot:header>
            <h1>
                {{ __('app.users') }}
            </h1>
        </x-slot:header>

        <ul>
            <li class="flex gap-10 p-1.5 bg-blue-400 text-white">
                <p class="column-entry">{{ __('app.firstname') }}</p>
                <p class="column-entry">{{ __('app.lastname') }}</p>
                <p class="column-entry">{{ __('app.role') }}</p>
            </li>
            @foreach($users as $user)
                <li>
                    <a href="{{ route('users.show', $user->id) }}">
                        <p class="column-entry">{{ $user->firstname }}</p>
                        <p class="column-entry">{{ $user->lastname }}</p>
                        <p class="column-entry">{{ $user->role }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="button-bottom-bar">
            <x-partials.action-link
                    href="{{ route('users.create') }}">{{ __('app.create_new_user') }}
            </x-partials.action-link>
        </div>
    </div>

</x-app-layout>