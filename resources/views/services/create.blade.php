<x-app-layout>
    <div class="wrapper">

        <h1>{{ __('app.create_new_service') }}</h1>

        <form method="POST" action="{{ route('services.store') }}" id="service-form">
            @csrf

            <x-forms.input-field
                    name="name"
                    label="{{ __('app.service') }}"
                    type="text"
                    :required="true"/>

            <x-forms.input-field
                    name="costs_per_hour"
                    label="{{ __('app.costs_per_hour') }}"
                    type="text"
                    :required="true"/>

            <x-forms.textarea-field
                    name="description"
                    label="{{ __('app.description') }}"
                    value="{{ $service->description }}"
                    rows="9"
            />
        </form>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/services"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <button form="service-form">{{ __('app.save') }}</button>
        </div>
    </div>
</x-app-layout>