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

                <!-- Firstname -->
                <x-forms.field>
                    <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="firstname" name="firstname" id="firstname" required/>
                        @error('firstname') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- Lastname -->
                <x-forms.field>
                    <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="lastname" name="lastname" id="lastname" required/>
                        @error('lastname') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- Email -->
                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="email" name="email" id="email" type="email" required/>
                        @error('email') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- Phone -->
                <x-forms.field>
                    <x-forms.label for="phone">{{ __('app.phone') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="phone" name="phone" id="phone"/>
                        @error('phone') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- Street -->
                <x-forms.field>
                    <x-forms.label for="street">{{ __('app.street') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="street" name="street" id="street"/>
                        @error('street') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- Housenumber -->
                <x-forms.field>
                    <x-forms.label for="house_number">{{ __('app.house_number') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model.="house_number" name="house_number" id="house_number"/>
                        @error('house_number') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- City -->
                <x-forms.field>
                    <x-forms.label for="city">{{ __('app.city') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="city" name="city" id="city"/>
                        @error('city') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>

                <!-- Zipcode -->
                <x-forms.field>
                    <x-forms.label for="zip_code">{{ __('app.zip_code') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input wire:model="zip_code" name="street" id="zip_code"/>
                        @error('zip_code') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </x-forms.field>
            </div>
            <!-- Relation Manager für Verträge -->
            <livewire:relation-manager :model="$customer" relatedModel="contracts"/>

            <!-- Submit Button -->
            <div class="button-bar">
                <x-partials.action-link href="/customers"
                                        class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
                <x-forms.delete-button :route="route('customers.destroy', $customer->id)" class="delete-button">
                    {{ __('app.delete') }}
                </x-forms.delete-button>
                <x-forms.button>{{ __('app.save') }}</x-forms.button>
            </div>
        </div>
    </form>
</div>

