<x-app-layout>
    <form method="POST" action="{{ route('services.update', $service->id) }}">
        @csrf
        @method('PUT')

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_service_entry') }}</h1>
            <div class="edit-wrapper">

                <x-forms.field>
                    <x-forms.label for="name">{{ __('app.service') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="name" id="name" value="{{ $service->name }}" required/>

                        <x-forms.error name="name"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="description">{{ __('app.description') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.textarea name="description"
                                          id="description" value="">{{ $service->description }}</x-forms.textarea>

                        <x-forms.error name="description"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="costs_per_hour">{{ __('app.costs_per_hour') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="costs_per_hour" id="costs_per_hour"
                                       value="{{ $service->cost_per_hour }}"
                                       required/>

                        <x-forms.error name="costs_per_hour"/>
                    </div>
                </x-forms.field>

                <div class="button-bar">
                    <x-partials.action-link href="/services"
                                            class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
                    <x-forms.delete-button :route="route('services.destroy', $service->id)"
                                           class="delete-button">{{ __('app.delete') }}</x-forms.delete-button>
                    <x-forms.button>{{ __('app.save') }}</x-forms.button>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>

