<x-app-layout>
    <form method="POST" action="{{ route('contracts.store') }}">
        @csrf
        <div class="form-input-wrapper">
            <h1>{{ __('app.create_new_contract') }}</h1>
            <div class="edit-wrapper">

                <x-forms.field>
                    <x-forms.label for="name">{{ __('app.name') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="name" id="name" required/>

                        <x-forms.error name="name"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="flatrate">{{ __('app.flatrate') }}:</x-forms.label>
                    <div class="mt-2">
                        <input type="checkbox" name="flatrate" id="flatrate"/>

                        <x-forms.error name="flatrate"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="hours">{{ __('app.hours') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="hours" id="hours"/>

                        <x-forms.error name="hours"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="monthly_costs">{{ __('app.monthly_costs') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="monthly_costs" id="monthly_costs"/>

                        <x-forms.error name="monthly_costs"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="start_date">{{ __('app.start_date') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="start_date" id="start_date" required/>

                        <x-forms.error name="start_date"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="end_date">{{ __('app.end_date') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="end_date" id="end_date"/>

                        <x-forms.error name="end_date"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="service_id[]">{{ __('app.services') }}:</x-forms.label>
                    <div class="mt-2">
                        <select name="service_id[]" multiple>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" @if($contract->services->contains($service->id))
                                    selected
                                        @endif>{{ $service->name }}</option>
                            @endforeach
                        </select>

                        <x-forms.error name="start_date"/>
                    </div>
                </x-forms.field>

            </div>
        </div>

        <div class="button-bar">
            <x-partials.action-link href="/contracts"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.button>{{ __('app.save') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>