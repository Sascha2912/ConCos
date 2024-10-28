<x-app-layout>
    <div class="wrapper">
        <h1>{{ __('app.create_new_user') }}</h1>
        <form method="POST" action="{{ route('users.store') }}" id="user-form">
            @csrf

            <x-forms.input-field
                    name="firstname"
                    label="{{ __('app.firstname') }}"
                    type="text"
                    :required="true"/>

            <x-forms.input-field
                    name="lastname"
                    label="{{ __('app.lastname') }}"
                    type="text"
                    :required="true"/>

            <x-forms.input-field
                    name="email"
                    label="{{ __('app.email') }}"
                    type="text"
                    :required="true"/>

            <!-- Dropdown für Rolle -->
            <x-forms.select-field
                    name="role"
                    label="{{ __('app.role') }}"
                    :options="$roles"/>

            <x-forms.input-field
                    name="password"
                    label="{{ __('app.password') }}"
                    type="password"/>

        </form>
        <div class="button-bottom-bar">
            <x-partials.action-link href="/users"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <button form="user-form">{{ __('app.create_user') }}</button>
        </div>
    </div>
</x-app-layout>
