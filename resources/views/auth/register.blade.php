<x-auth-layout>

    <form method="POST" class="form-wrapper max-w-xs"
          action="{{ route('register_store') }}">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.register') }}</h1>
            <div class="form-input">
                <x-forms.field>
                    <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="firstname" id="firstname" required/>

                        <x-forms.error name="firstname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="lastname" id="lastname" required/>

                        <x-forms.error name="lastname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="email" id="email" type="email" required/>

                        <x-forms.error name="email"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="password">{{ __('app.password') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="password" id="password" type="password" required/>

                        <x-forms.error name="password"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="password_confirmation">{{ __('app.password_confirmed') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="password_confirmation" id="password_confirmation" type="password"
                                       required/>

                        <x-forms.error name="password_confirmation"/>
                    </div>
                </x-forms.field>

            </div>

        </div>

        <div class="button-bar">
            <x-partials.action-link href="/" class="back">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.button>{{ __('app.register') }}</x-forms.button>
        </div>
    </form>
</x-auth-layout>
