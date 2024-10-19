<x-app-layout>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_user') }}</h1>
            <div class="edit-wrapper">

                <x-forms.field>
                    <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="firstname" id="firstname" value="{{ $user->firstname }}" required/>

                        <x-forms.error name="firstname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="lastname" id="lastname" value="{{ $user->lastname }}" required/>

                        <x-forms.error name="lastname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="email" id="email" type="email" value="{{ $user->email }}"
                                       required/>

                        <x-forms.error name="email"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.password') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="password" id="password" type="password"
                                       value="{{ $user->password }}"
                                       required/>

                        <x-forms.error name="password"/>
                    </div>
                </x-forms.field>

            </div>
        </div>

        <div class="button-bar">
            <x-partials.action-link href="/users"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.delete-button :route="route('users.destroy', $user->id)"
                                   class="delete-button">{{ __('app.delete') }}</x-forms.delete-button>
            <x-forms.button>{{ __('app.save') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>