<div>
    <form wire:submit.prevent="save">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.create_contract') }}</h1>

            <div class="edit-wrapper">

                <!-- Form Input Fields -->
                <div>
                    <x-forms.field>
                        <x-forms.label for="name">{{ __('app.contract_name') }}:</x-forms.label>
                        <x-forms.input wire:model="name" name="name" id="name" required/>
                    </x-forms.field>
                    <x-forms.error name="name"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="monthly_costs">{{ __('app.monthly_price') }}: €</x-forms.label>
                        <x-forms.input wire:model="monthly_costs" name="monthly_costs" id="monthly_costs"
                                       type="monthly_costs"/>
                    </x-forms.field>
                    <x-forms.error name="monthly_costs"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="flatrate">{{ __('app.flatrate') }}:</x-forms.label>
                        <input wire:model="flatrate" name="flatrate" id="flatrate" type="checkbox"/>
                    </x-forms.field>
                    <x-forms.error name="flatrate"/>
                </div>

                <!-- Contracts Dropdown -->
                <x-forms.field>
                    <x-forms.label for="dropdown">{{ __('app.add_service') }}:</x-forms.label>
                    <select class="dropdown" id="dropdown" wire:model="selectedServiceId"
                            wire:key="service-select-{{ now() }}"
                            wire:change="addService($event.target.value)">
                        <option value="default"></option>
                        @foreach($availableServices as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </x-forms.field>

            </div>

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
                                <label for="service_hours_{{ $service['id'] }}"
                                       class="block text-sm font-medium text-gray-700">
                                    {{ __('app.service_hours') }}:
                                </label>
                                <input wire:model="serviceHours.{{ $service['id'] }}"
                                       name="service_hours"
                                       id="service_hours_{{ $service['id'] }}"
                                       type="text" required
                                       class="block w-24 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>

                                <!-- Delete Button -->
                                <x-dropdown.delete-button class="text-red-600 hover:text-red-800"
                                                          wire:click="removeService({{ $service['id'] }})"/>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Button-Bottom-Bar -->
            <div class="button-bottom-bar">
                <x-partials.action-link href="/contracts" class="back">{{ __('app.back') }}</x-partials.action-link>
                <x-forms.button>{{ __('app.save') }}</x-forms.button>
            </div>

        </div>
    </form>
</div>

