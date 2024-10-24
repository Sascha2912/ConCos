<x-app-layout>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.create_new_user') }}</h1>
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
                        <x-forms.input name="email" id="email" type="email" value="{{ $user->email }}"
                                       required/>
                    </x-forms.field>
                    <x-forms.error name="email"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="email">{{ __('app.password') }}:</x-forms.label>
                        <x-forms.input name="password" id="password" type="password"
                                       value="{{ $user->password }}"
                                       required/>

                    </x-forms.field>
                    <x-forms.error name="password"/>
                </div>
            </div>
        </div>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/users"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.button>{{ __('app.create_user') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>
