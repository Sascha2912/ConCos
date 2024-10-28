<div>

    <h1>{{ __('app.create_contract') }}</h1>
    <form wire:submit.prevent="save" id="contract-form">
        @csrf

        <!-- Form Input Fields -->
        <x-forms.input-field
                name="name"
                label="{{ __('app.contract_name') }}"
                type="text"
                :required="true"
                wireModel="name"/>

        <x-forms.input-field
                name="monthly_costs"
                label="{{ __('app.monthly_price') }}"
                type="text"
                :required="true"
                wireModel="monthly_costs"/>

        <x-forms.input-field
                name="flatrate"
                label="{{ __('app.flatrate') }}"
                type="checkbox"

                wireModel="flatrate"/>

        <!-- Service Dropdown -->
        <x-forms.select-field
                name="dropdown"
                label="{{ __('app.add_service') }}"
                :options="$availableServices"
                selected="{{ $selectedServiceId }}"
                wireModel="selectedServiceId"
                wireKey="service-select-{{ now() }}"
                wireChange="addService($event.target.value)"
        />

    </form>
    <div>
        <!-- Selected Contracts -->
        <h2 class="item-heading">{{ __('app.current_services') }}:</h2>
        <ul class="space-y-4">
            @foreach($tmpServices as $service)
                <li class="flex items-center justify-between p-4 bg-white shadow-md rounded-lg"
                    wire:key="service-{{ $service['id'] }}">
                    <!-- Service Information -->
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold text-gray-800">{{ $service['name'] }}</span>
                    </div>

                    <!-- Delete Button and Input for Service Hours -->
                    <div class="flex items-center space-x-4">
                        <x-forms.input-field
                                name="service_hours"
                                id="service_hours_{{ $service['id'] }}"
                                label="{{ __('app.service_hours') }}"
                                type="text"
                                :required="true"
                                wireModel="serviceHours.{{ $service['id'] }}"/>

                        <!-- Delete Button -->
                        <x-item.delete-button
                                wire:click="removeService({{ $service['id'] }})"/>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Button-Bottom-Bar -->
    <div class="button-bottom-bar">
        <x-partials.action-link href="/contracts" class="back">{{ __('app.back') }}</x-partials.action-link>
        <button form="contract-form">{{ __('app.save') }}</button>
    </div>
</div>

