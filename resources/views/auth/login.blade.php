<x-auth-layout>

    <form method="POST" class="form-wrapper max-w-md" action="/login">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.login') }}</h1>
            <div class="form-input">

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="email" id="email" type="email" :value="old('email')" required/>

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
            </div>

        </div>

        <div class="button-bar">
            <x-partials.action-link href="/register">{{ __('app.register') }}</x-partials.action-link>
            <x-forms.button>{{ __('app.login') }}</x-forms.button>
        </div>
    </form>
</x-auth-layout>
