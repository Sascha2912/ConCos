<div>
    <form wire:submit.prevent="save">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_customer') }}</h1>

            <div class="edit-wrapper">

                <!-- Button-Top-Bar -->
                <x-partials.action-link href="/timelogs" :active="request()->is('timelogs')">
                    {{ __('app.time_logs') }}
                </x-partials.action-link>
                <x-partials.action-link
                        href="{{ route('invoice.create', $customer->id) }}">{{ __('app.print') }}</x-partials.action-link>

                <!-- Form Input Fields -->

                <x-forms.field>
                    <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                    <x-forms.input wire:model="firstname" name="firstname" id="firstname" required/>
                    <x-forms.error name="firstname"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                    <x-forms.input wire:model="lastname" name="lastname" id="lastname" requried/>
                    <x-forms.error name="lastname"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <x-forms.input wire:model="email" name="email" id="email" type="email" required/>
                    <x-forms.error name="email"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="phone">{{ __('app.phone') }}:</x-forms.label>
                    <x-forms.input wire:model="phone" name="phone" id="phone"/>
                    <x-forms.error name="phone"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="street">{{ __('app.street') }}:</x-forms.label>
                    <x-forms.input wire:model="street" name="street" id="street"/>
                    <x-forms.error name="street"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="house_number">{{ __('app.house_number') }}:</x-forms.label>
                    <x-forms.input wire:model.="house_number" name="house_number" id="house_number"/>
                    <x-forms.error name="house_number"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="city">{{ __('app.city') }}:</x-forms.label>
                    <x-forms.input wire:model="city" name="city" id="city"/>
                    <x-forms.error name="city"/>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="zip_code">{{ __('app.zip_code') }}:</x-forms.label>
                    <x-forms.input wire:model="zip_code" name="street" id="zip_code"/>
                    <x-forms.error name="zip_code"/>
                </x-forms.field>

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
                        <li class="item" wire:key="contract-{{ $contract['id'] }}">
                            <a class="item-link" href="{{ route('contracts.edit', $contract['id']) }}">
                                {{ $contract['name'] }}
                            </a>
                            <x-dropdown.delete-button class="item-delete-button" type="button"
                                                      wire:click="removeContract({{ $contract['id'] }})"/>

                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Button-Bottom-Bar -->
            <div class="button-bar">
                <x-partials.action-link href="/customers"
                                        class="back ">{{ __('app.back') }}</x-partials.action-link>
                <livewire.delete-button class="delete-button"
                                        onclick="return confirm('{{ __('app.are_you_sure') }}');"
                                        wire:click="deleteCustomer({{ $customer->id }})">
                    {{ __('app.delete') }}
                </livewire.delete-button>
                <x-forms.button>{{ __('app.save') }}</x-forms.button>
            </div>

        </div>
    </form>
</div>

