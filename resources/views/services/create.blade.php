<x-app-layout>
    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.create_new_service') }}</h1>
            <div class="edit-wrapper">

                <x-forms.field>
                    <x-forms.label for="name">{{ __('app.service') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="name" id="name" required/>

                        <x-forms.error name="name"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="description">{{ __('app.description') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.textarea name="description"
                                          id="description"></x-forms.textarea>

                        <x-forms.error name="description"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="costs_per_hour">{{ __('app.costs_per_hour') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="costs_per_hour" id="costs_per_hour"
                                       required/>

                        <x-forms.error name="costs_per_hour"/>
                    </div>
                </x-forms.field>

                <div class="button-bar">
                    <x-partials.action-link href="/services"
                                            class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
                    <x-forms.button>{{ __('app.save') }}</x-forms.button>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>