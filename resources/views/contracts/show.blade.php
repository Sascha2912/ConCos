<x-app-layout>

    <div class="wrapper">
        <h1>{{ __('app.edit_contract') }}</h1>
        <form>
            @csrf
            <!-- Form Input Fields -->
            <x-forms.input-field
                    name="name"
                    label="{{ __('app.contract_name') }}"
                    type="text"
                    :value="$contract->name"
                    :required="true"
                    :disabled="true"/>

            <x-forms.input-field
                    name="monthly_costs"
                    label="{{ __('app.monthly_price') }}"
                    type="text"
                    :value="$contract->monthly_costs"
                    :required="true"
                    :disabled="true"/>

            <x-forms.input-field
                    name="flatrate"
                    label="{{ __('app.flatrate') }}"
                    type="checkbox"
                    :value="$contract->flatrate"
                    :disabled="true"/>
        </form>

        <div>
            <!-- Selected Services -->
            <h2 class="item-heading">{{ __('app.current_services') }}:</h2>
            <ul class="item-wrapper">
                @foreach($services as $service)
                    <li>
                        <!-- Service Information -->
                        <div>
                            <span class="item-text">{{ $service['name'] }}</span>
                        </div>

                        <!-- Delete Button and Input for Service Hours -->
                        <div class="item-edit">
                            <x-forms.input-field
                                    name="service_hours"
                                    label="{{ __('app.service_hours') }}"
                                    type="text"
                                    :value="$service->pivot->hours"
                                    :required="true"
                                    :disabled="true"/>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Button-Bottom-Bar -->
        <div class="button-bottom-bar">
            <x-partials.action-link href="/contracts" class="back">{{ __('app.back') }}</x-partials.action-link>
        </div>
    </div>

</x-app-layout>