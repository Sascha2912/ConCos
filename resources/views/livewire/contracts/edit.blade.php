<div>
    <form wire:submit.prevent="save">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_contract') }}</h1>

            <div class="edit-wrapper">

                <!-- Form Input Fields -->
                <x-forms.field>
                    <x-forms.label for="name">{{ __('app.contract_name') }}:</x-forms.label>
                    <x-forms.input wire:model="name" name="name" id="name" required/>
                    <x-forms.error name="name"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="flatrate">{{ __('app.flatrate') }}:</x-forms.label>
                    <input type="checkbox" name="flatrate" id="flatrate"
                           @if($contract->flatrate) checked @endif/>

                    <x-forms.error name="flatrate"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="hours">{{ __('app.hours') }}:</x-forms.label>
                    <x-forms.input wire:model="hours" name="hours" id="hours"/>
                    <x-forms.error name="hours"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="monthly_costs">{{ __('app.monthly_costs') }}:</x-forms.label>
                    <x-forms.input wire:model="monthly_costs" name="monthly_costs" id="monthly_costs"/>
                    <x-forms.error name="monthly_costs"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="start_date">{{ __('app.start_date') }}:</x-forms.label>
                    <x-forms.input wire:model="start_date" name="start_date" id="start_date" required/>
                    <x-forms.error name="start_date"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="end_date">{{ __('app.end_date') }}:</x-forms.label>
                    <x-forms.input wire:model="end_date" name="end_date" id="end_date"/>
                    <x-forms.error name="end_date"/>
                </x-forms.field>

                <!-- Service Dropdown -->
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
                <!-- Selected Services -->
                <h2 class="item-heading">{{ __('app.current_services') }}:</h2>
                <ul class="item-wrapper">
                    @foreach($tmpServices as $service)
                        <li class="item" wire:key="service-{{ $service['id'] }}">
                            <a class="item-link" href="{{ route('services.edit', $service['id']) }}">
                                {{ $service['name'] }}
                            </a>
                            <x-dropdown.delete-button class="item-delete-button" type="button"
                                                      wire:click="removeService({{ $service['id'] }})"/>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Button-Bottom-Bar -->
            <div class="button-bar">
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
