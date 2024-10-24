<x-auth-layout>

    <form class="py-20" method="POST" action="/login">
        @csrf

        <h1>{{ __('app.login') }}</h1>
        <div class="login-wrapper">

            <div>
                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <x-forms.input name="email" id="email" type="email" :value="old('email')" required/>
                </x-forms.field>
                <x-forms.error name="email"/>
            </div>

            <div>
                <x-forms.field>
                    <x-forms.label for="password">{{ __('app.password') }}:</x-forms.label>
                    <x-forms.input name="password" id="password" type="password" required/>
                </x-forms.field>
                <x-forms.error name="password"/>
            </div>
        </div>

        <div class="button-bottom-bar">
            <x-forms.button>{{ __('app.login') }}</x-forms.button>
        </div>
    </form>
</x-auth-layout>
