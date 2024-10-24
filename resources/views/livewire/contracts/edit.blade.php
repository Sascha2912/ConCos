<div>
    <form wire:submit.prevent="save">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_contract') }}</h1>

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
                        <x-forms.label for="flatrate">{{ __('app.flatrate') }}:</x-forms.label>
                        <input wire:model="flatrate" name="flatrate" id="flatrate" type="checkbox"
                               @if($contract->flatrate) checked @endif/>
                    </x-forms.field>
                    <x-forms.error name="flatrate"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="monthly_costs">{{ __('app.monthly_price') }}: €</x-forms.label>
                        <x-forms.input wire:model="monthly_costs" name="monthly_costs" id="monthly_costs" required/>
                    </x-forms.field>
                    <x-forms.error name="monthly_costs"/>
                </div>

                <!-- Service Dropdown -->
                <x-forms.field>
                    <x-forms.label for="dropdown">{{ __('app.add_service') }}:</x-forms.label>
                    <select class="dropdown" id="dropdown" wire:model="selectedServiceId"
                            wire:key="service-select-{{ now() }}"
                            wire:change="addService($event.target.value)">
                        <option value="default"></option>
                        @foreach($availableServices as $service)
                            <option class="text-black" value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </x-forms.field>
            </div>

            <div>
                <!-- Selected Services -->
                <h2 class="item-heading">{{ __('app.current_services') }}:</h2>
                <ul class="item-wrapper">
                    @foreach($tmpServices as $service)
                        <li class="item-col"
                            wire:key="service-{{ $service['id'] }}">
                            <!-- Service Information -->
                            <div class="item">
                                <span class="item-text">{{ $service['name'] }}</span>
                            </div>

                            <!-- Delete Button and Input for Service Hours -->
                            <div class="item-edit">
                                <label for="service_hours_{{ $service['id'] }}"
                                       class="item-label">
                                    {{ __('app.service_hours') }}:
                                </label>
                                <input wire:model="serviceHours.{{ $service['id'] }}"
                                       name="service_hours"
                                       id="service_hours_{{ $service['id'] }}"
                                       type="text" required
                                       class="item-input"/>

                                <!-- Delete Button -->
                                <x-dropdown.delete-button
                                        wire:click="removeService({{ $service['id'] }})"/>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Button-Bottom-Bar -->
            <div class="button-bottom-bar">
                <x-partials.action-link href="/contracts" class="back">{{ __('app.back') }}</x-partials.action-link>
                <livewire.delete-button class="delete-button"
                                        onclick="return confirm('{{ __('app.are_you_sure') }}');"
                                        wire:click="deleteContract({{ $contract->id }})">
                    {{ __('app.delete') }}
                </livewire.delete-button>
                <x-forms.button>{{ __('app.save') }}</x-forms.button>
            </div>

        </div>
    </form>
</div>
