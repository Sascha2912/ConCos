<x-auth-layout>
    <main>

        <h1>{{ __('app.login') }}</h1>
        <form class="grid-cols-1" method="POST" action="/login">
            @csrf

            <x-forms.input-field
                    name="email"
                    label="{{ __('app.email') }}"
                    type="email"
                    :required="true"
            />
            <x-forms.input-field
                    name="password"
                    label="{{ __('app.password') }}"
                    type="password"
                    :required="true"
            />
            <div class="button-bottom-bar">
                <button>{{ __('app.login') }}</button>
            </div>
        </form>

    </main>

</x-auth-layout>
