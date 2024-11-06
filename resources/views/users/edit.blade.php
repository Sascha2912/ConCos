<x-app-layout>

    <div class="wrapper">
        <h1>{{ __('app.edit_user') }}</h1>
        <form method="POST" action="{{ route('users.update', $user->id) }}" id="user-form">
            @csrf
            @method('PUT')

            <x-forms.input-field
                    name="firstname"
                    label="{{ __('app.firstname') }}"
                    type="text"
                    value="{{ $user->firstname }}"
                    :required="true"/>

            <x-forms.input-field
                    name="lastname"
                    label="{{ __('app.lastname') }}"
                    value="{{ $user->lastname }}"
                    type="text"
                    :required="true"/>

            <x-forms.input-field
                    name="email"
                    label="{{ __('app.email') }}"
                    value="{{ $user->email }}"
                    type="text"
                    :required="true"/>

            <!-- Dropdown für Rolle -->
            <x-forms.select-field
                    name="role"
                    label="{{ __('app.role') }}"
                    :options="$roles"
                    selected="{{ $user->role }}"
                    value="{{ $user->role }}"
                    :disabled="!$user->isAdmin()"
            />

            <x-forms.input-field
                    name="current_password"
                    label="{{ __('app.current_password') }}"
                    type="password"/>

            <div></div>

            <!-- Passwort ändern -->
            <x-forms.input-field
                    name="new_password"
                    label="{{ __('app.new_password') }}"
                    type="password"/>

            <x-forms.input-field
                    name="new_password_confirmation"
                    label="{{ __('app.confirm_password') }}"
                    type="password"/>
        </form>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/users"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <button class="delete" form="delete-form">
                {{ $slot ?? __('app.delete') }}
            </button>
            <button form="user-form">{{ __('app.save') }}</button>
        </div>

        <form class="hidden" method="POST" action="/users/{{ $user->id }}" id="delete-form">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-app-layout>