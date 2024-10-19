<x-app-layout>
    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_customer') }}</h1>
            <div class="edit-wrapper">

                <x-forms.field>
                    <x-forms.label for="firstname">{{ __('app.firstname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="firstname" id="firstname" value="{{ $customer->firstname }}" required/>

                        <x-forms.error name="firstname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="lastname">{{ __('app.lastname') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="lastname" id="lastname" value="{{ $customer->lastname }}" required/>

                        <x-forms.error name="lastname"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="email">{{ __('app.email') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="email" id="email" type="email" value="{{ $customer->email }}"
                                       required/>

                        <x-forms.error name="email"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="phone">{{ __('app.phone') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="phone" id="phone" value="{{ $customer->phone }}"/>

                        <x-forms.error name="phone"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="street">{{ __('app.street') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="street" id="street" value="{{ $customer->street }}"/>

                        <x-forms.error name="street"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="house_number">{{ __('app.house_number') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="house_number" id="house_number" value="{{ $customer->house_number }}"/>

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
                        <x-forms.input name="zip_code" id="zip_code" value="{{ $customer->zip_code }}"/>

                        <x-forms.error name="zip_code"/>
                    </div>
                </x-forms.field>

                <x-partials.action-link href="/timelogs" :active="request()->is('timelogs')">
                    {{ __('app.time_logs') }}
                </x-partials.action-link>

                <x-forms.field>
                    <form action="{{ route('customer.contracts.store', $customer->id) }}" method="POST">
                        @csrf
                        <x-dropdown.field>
                            <x-slot name="trigger">
                                <x-dropdown.button>{{ __('app.add_contract') }}</x-dropdown.button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach($contracts as $contract)
                                    <x-dropdown.link href="#"
                                                     onclick="event.preventDefault(); document.getElementById('contract-id').value = '{{ $contract->id }}'; document.getElementById('contract-form').submit();">
                                        {{ $contract->name }}
                                    </x-dropdown.link>
                                @endforeach
                            </x-slot>
                        </x-dropdown.field>
                        <input type="hidden" name="contract_id" id="contract-id" value="">
                    </form>
                </x-forms.field>
            </div>

            <ul class="item-wrapper grid grid-cols-4">
                @foreach($contracts as $contract)
                    @if($customer->contracts->contains($contract->id))
                        <li class="relative item">
                            {{ $contract->name }}
                            <x-forms.delete-button
                                    class="text-xl text-gray-600 hover:text-gray-900 absolute -top-1.5 right-1 h-full w-4"
                                    :route="route('customer.contracts.destroy', [$customer->id, $contract->id])"/>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="button-bar">
            <x-partials.action-link href="/customers"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-partials.action-link
                    href="{{ route('invoice.create', $customer->id) }}">{{ __('app.print') }}</x-partials.action-link>
            <x-forms.delete-button :route="route('customers.destroy', $customer->id)" class="delete-button">
                {{ __('app.delete') }}
            </x-forms.delete-button>
            <x-forms.button>{{ __('app.save') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>