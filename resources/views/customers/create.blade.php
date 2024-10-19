<x-app-layout>
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="form-input-wrapper">
            <h1>{{ __('app.create_new_customer') }}</h1>
            <div class="edit-wrapper">

                <x-forms.field>
                    <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="firstname" id="firstname" required/>

                        <x-forms.error name="firstname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="lastname" id="lastname" required/>

                        <x-forms.error name="lastname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="email" id="email" type="email"
                                       required/>

                        <x-forms.error name="email"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.password') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="password" id="password" type="password"
                                       required/>

                        <x-forms.error name="password"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="street">{{ __('app.street') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="street" id="street"/>

                        <x-forms.error name="street"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="house_number">{{ __('app.house_number') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="house_number" id="house_number"/>

                        <x-forms.error name="house_number"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="city">{{ __('app.city') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="city" id="city" value="{{ $customer->city }}"/>

                        <x-forms.error name="city"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="zip_code">{{ __('app.zip_code') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="zip_code" id="zip_code"/>

                        <x-forms.error name="zip_code"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="phone">{{ __('app.phone') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="phone" id="phone"/>

                        <x-forms.error name="phone"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="contract_id[]">{{ __('app.contracts') }}:</x-forms.label>
                    <select name="contract_id[]" multiple>
                        @foreach($contracts as $contract)
                            <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                        @endforeach
                    </select>
                </x-forms.field>

            </div>
        </div>
        <div class="button-bar">
            <x-partials.action-link href="/customers"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.button>{{ __('app.save') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>