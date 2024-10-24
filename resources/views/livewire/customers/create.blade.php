<div>
    <form wire:submit.prevent="save">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.create_customer') }}</h1>

            <div class="edit-wrapper">

                <!-- Form Input Fields -->
                <div>
                    <x-forms.field>
                        <x-forms.label for="name">{{ __('app.company_name') }}:</x-forms.label>
                        <x-forms.input wire:model="name" name="name" id="name" required/>
                    </x-forms.field>
                    <x-forms.error name="name"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="managing_director">{{ __('app.managing_director') }}:</x-forms.label>
                        <x-forms.input wire:model="managing_director" name="managing_director" id="managing_director"
                                       required/>
                    </x-forms.field>
                    <x-forms.error name="managing_director"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="phone">{{ __('app.phone') }}:</x-forms.label>
                        <x-forms.input wire:model="phone" name="phone" id="phone"/>
                    </x-forms.field>
                    <x-forms.error name="phone"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                        <x-forms.input wire:model="email" name="email" id="email" type="email" required/>
                    </x-forms.field>
                    <x-forms.error name="email"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="street">{{ __('app.street') }}:</x-forms.label>
                        <x-forms.input wire:model="street" name="street" id="street"/>
                    </x-forms.field>
                    <x-forms.error name="street"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="house_number">{{ __('app.house_number') }}:</x-forms.label>
                        <x-forms.input wire:model="house_number" name="house_number" id="house_number"/>
                    </x-forms.field>
                    <x-forms.error name="house_number"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="city">{{ __('app.city') }}:</x-forms.label>
                        <x-forms.input wire:model="city" name="city" id="city"/>
                    </x-forms.field>
                    <x-forms.error name="city"/>
                </div>

                <div>
                    <x-forms.field>
                        <x-forms.label for="zip_code">{{ __('app.zip_code') }}:</x-forms.label>
                        <x-forms.input wire:model="zip_code" name="zip_code" id="zip_code"/>
                    </x-forms.field>
                    <x-forms.error name="zip_code"/>
                </div>

                <!-- Contracts Dropdown -->
                <x-forms.field>
                    <x-forms.label for="dropdown">{{ __('app.add_contract') }}:</x-forms.label>
                    <select class="dropdown" id="dropdown" wire:model="selectedContractId"
                            wire:key="contract-select-{{ now() }}"
                            wire:change="addContract($event.target.value)">
                        <option value="default"></option>
                        @foreach($availableContracts as $contract)
                            <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                        @endforeach
                    </select>
                </x-forms.field>
            </div>

            <div>
                <!-- Selected Contracts -->
                <h2 class="item-heading">{{ __('app.current_contracts') }}:</h2>
                <ul class="item-wrapper">
                    @foreach($tmpContracts as $contract)
                        <li class="item-col" wire:key="contract-{{ $contract['id'] }}">
                            <!-- Contract Information -->
                            <div class="item">
                                <span class="item-text">{{ $contract['name'] }}</span>
                            </div>
                            <div class="item-edit">
                                <label for="create_date_{{ $contract['id'] }}"
                                       class="item-label">
                                    {{ __('app.create_date') }}:
                                </label>
                                <input wire:model="contractDates.{{ $contract['id'] }}.create_date" name="create_date"
                                       id="create_date_{{ $contract['id'] }}"
                                       type="date"
                                       class="item-input"/>
                                <x-forms.error name="create_date"/>

                                <label for="start_date_{{ $contract['id'] }}"
                                       class="item-label">
                                    {{ __('app.start_date') }}:
                                </label>
                                <input wire:model="contractDates.{{ $contract['id'] }}.start_date" name="start_date"
                                       id="start_date_{{ $contract['id'] }}"
                                       type="date"
                                       class="item-input" required/>
                                <x-forms.error name="start_date"/>

                                <label for="end_date_{{ $contract['id'] }}"
                                       class="item-label">
                                    {{ __('app.end_date') }}:
                                </label>
                                <input wire:model="contractDates.{{ $contract['id'] }}.end_date" name="end_date"
                                       id="end_date_{{ $contract['id'] }}"
                                       type="date"
                                       class="item-input"/>
                                <x-forms.error name="end_date"/>

                                <!-- Delete Button -->
                                <x-dropdown.delete-button
                                        wire:click="removeContract({{ $contract['id'] }})"/>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Button-Bottom-Bar -->
            <div class="button-bottom-bar">
                <x-partials.action-link href="/customers" class="back">{{ __('app.back') }}</x-partials.action-link>
                <x-forms.button>{{ __('app.save') }}</x-forms.button>
            </div>

        </div>
    </form>
</div>

