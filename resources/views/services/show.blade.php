<x-app-layout>

    <div class="wrapper">
        <h1>{{ __('app.service') }}</h1>

        <form method="POST" action="{{ route('services.update', $service->id) }}" id="service-form">
            @csrf
            @method('PUT')

            <x-forms.input-field
                    name="name"
                    label="{{ __('app.service') }}"
                    value="{{ $service->name }}"
                    type="text"
                    :required="true"
                    :disabled="true"/>

            <x-forms.input-field
                    name="costs_per_hour"
                    label="{{ __('app.costs_per_hour') }}"
                    value="{{ $service->costs_per_hour }}"
                    type="text"
                    :required="true"
                    :disabled="true"/>

            <x-forms.textarea-field
                    name="description"
                    label="{{ __('app.description') }}"
                    value="{{ $service->description }}"
                    rows="9"
                    :disabled="true"/>
        </form>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/services"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
        </div>
    </div>
</x-app-layout>

