<div class="wrapper">
    <h1>{{ __('app.create_customer') }}</h1>
    <!-- Form Input Fields -->
    <form wire:submit.prevent="save" id="customer-form">
        @csrf

        <x-forms.input-field
                name="name"
                label="{{ __('app.company_name') }}"
                type="text"
                :required="true"
                wireModel="name"/>

        <x-forms.input-field
                name="managing_director"
                label="{{ __('app.managing_director') }}"
                type="text"
                :required="true"
                wireModel="managing_director"/>

        <x-forms.input-field
                name="phone"
                label="{{ __('app.phone') }}"
                type="text"
                wireModel="phone"/>

        <x-forms.input-field
                name="email"
                label="{{ __('app.email') }}"
                type="email"
                :required="true"
                wireModel="email"/>

        <x-forms.input-field
                name="street"
                label="{{ __('app.street') }}"
                type="text"
                wireModel="street"/>

        <x-forms.input-field
                name="house_number"
                label="{{ __('app.house_number') }}"
                type="text"
                wireModel="house_number"/>

        <x-forms.input-field
                name="city"
                label="{{ __('app.city') }}"
                type="text"
                wireModel="city"/>

        <x-forms.input-field
                name="zip_code"
                label="{{ __('app.zip_code') }}"
                type="text"
                wireModel="zip_code"/>

        <!-- Contracts Dropdown -->
        <x-forms.select-field
                name="dropdown"
                label="{{ __('app.add_contract') }}"
                :options="$availableContracts"
                wireModel="selectedContractId"
                wireKey="contract-select-{{ now() }}"
                wireChange="addContract($event.target.value)"
        />
    </form>

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
                        <input name="create_date" id="create_date_{{ $contract['id'] }}" type="date"
                               wire:model="contractDates.{{ $contract['id'] }}.create_date" class="hidden">

                        <x-forms.input-field
                                name="start_date"
                                id="start_date_{{ $contract['id'] }}"
                                label="{{ __('app.start_date') }}"
                                type="date"
                                :required="true"
                                wireModel="contractDates.{{ $contract['id'] }}.start_date"/>

                        <x-forms.input-field
                                name="end_date"
                                id="end_date_{{ $contract['id'] }}"
                                label="{{ __('app.end_date') }}"
                                type="date"
                                wireModel="contractDates.{{ $contract['id'] }}.end_date"/>

                        <!-- Delete Button -->
                        <x-item.delete-button
                                wire:click="removeContract({{ $contract['id'] }})"/>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Button-Bottom-Bar -->
    <div class="button-bottom-bar">
        <x-partials.action-link href="/customers" class="back">{{ __('app.back') }}</x-partials.action-link>
        <button form="customer-form">{{ __('app.save') }}</button>
    </div>
</div>



