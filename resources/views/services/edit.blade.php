<x-app-layout>
    <form method="POST" action="{{ route('services.update', $service->id) }}">
        @csrf
        @method('PUT')

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_service_entry') }}</h1>
            <div class="edit-wrapper">

                <div>
                    <x-forms.field>
                        <x-forms.label for="name">{{ __('app.service') }}:</x-forms.label>
                        <x-forms.input name="name" id="name" value="{{ $service->name }}" required/>
                    </x-forms.field>
                    <x-forms.error name="name"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="description">{{ __('app.description') }}:</x-forms.label>
                        <x-forms.textarea name="description"
                                          id="description" value="">{{ $service->description }}</x-forms.textarea>
                    </x-forms.field>
                    <x-forms.error name="description"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="costs_per_hour">{{ __('app.costs_per_hour') }}:</x-forms.label>

                        <x-forms.input name="costs_per_hour" id="costs_per_hour" value="{{ $service->costs_per_hour }}"
                                       required/>
                    </x-forms.field>
                    <x-forms.error name="costs_per_hour"/>
                </div>

                <div class="button-bottom-bar">
                    <x-partials.action-link href="/services"
                                            class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
                    <button class="delete-button" form="delete-form">
                        {{ $slot ?? __('app.delete') }}
                    </button>
                    <x-forms.button>
                        {{ __('app.save') }}
                    </x-forms.button>
                </div>
            </div>
        </div>
    </form>

    <form class="hidden" method="POST" action="/services/{{ $service->id }}" id="delete-form">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>

