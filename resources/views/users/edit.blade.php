<x-app-layout>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_user') }}</h1>
            <div class="edit-wrapper">

                <div>
                    <x-forms.field>
                        <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                        <x-forms.input name="firstname" id="firstname" value="{{ $user->firstname }}" required/>
                    </x-forms.field>
                    <x-forms.error name="firstname"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                        <x-forms.input name="lastname" id="lastname" value="{{ $user->lastname }}" required/>
                    </x-forms.field>
                    <x-forms.error name="lastname"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                        <x-forms.input name="email" id="email" type="email" value="{{ $user->email }}" required/>
                    </x-forms.field>
                    <x-forms.error name="email"/>
                </div>

                <!-- Dropdown für Rolle -->
                <x-forms.select name="role" label="{{ __('app.role') }}" :options="$roles"
                                selected="{{ $user->role }}"/>

                <div>
                    <x-forms.field>
                        <x-forms.label for="current_password">{{ __('app.current_password') }}:</x-forms.label>
                        <x-forms.input name="current_password" id="current_password" type="password"/>
                    </x-forms.field>
                    <x-forms.error name="current_password"/>
                </div>

                <div></div>

                <!-- Passwort ändern -->
                <div>
                    <x-forms.field>
                        <x-forms.label for="new_password">{{ __('app.new_password') }}:</x-forms.label>
                        <x-forms.input name="new_password" id="new_password" type="password"/>
                    </x-forms.field>
                    <x-forms.error name="new_password"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="new_password_confirmation">{{ __('app.confirm_password') }}:</x-forms.label>
                        <x-forms.input name="new_password_confirmation" id="new_password_confirmation" type="password"/>
                    </x-forms.field>
                    <x-forms.error name="new_password_confirmation"/>
                </div>

            </div>
        </div>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/users"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <button class="delete-button" form="delete-form">
                {{ $slot ?? __('app.delete') }}
            </button>
            <x-forms.button>{{ __('app.save') }}</x-forms.button>
        </div>
    </form>

    <form class="hidden" method="POST" action="/users/{{ $user->id }}" id="delete-form">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>